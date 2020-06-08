<?php

namespace TwoFingers\Location\Iblock;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use TwoFingers\Location\Iblock;

/**
 * Class Location
 *
 * @package TwoFingers\Location\Iblock
 */
class Location extends Iblock
{
    const CODE              = 'tf_location_location';
    const OPTION_IBLOCK_ID  = 'location-iblock-id';

    const PROPERTY_FEATURED = 'FEATURED';
    const PROPERTY_DEFAULT  = 'DEFAULT';

    protected static $fileData;

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectException
     * @throws ArgumentException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public static function build()
    {
        if (!self::createType())
            return false;

        if (!self::createIblock())
            return false;

        if (!self::createCheckBoxProperty(self::PROPERTY_FEATURED, 100))
            return false;

        if (!self::createCheckBoxProperty(self::PROPERTY_DEFAULT, 200))
            return false;

        if (!self::addCountries())
            return false;

        if (!self::addRegions())
            return false;

        if (!self::addLocations())
            return false;

        return true;
    }

    /**
     * @return array
     */
    protected static function getFileData()
    {
        if (is_null(self::$fileData)) {
            self::$fileData = [];

            if (($handle = fopen(__DIR__ . "/../../include/cities.csv", "r")) !== FALSE)
                while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
                    self::$fileData[] = $data;
        }

        return self::$fileData;
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectException
     */
    public static function addCountries()
    {
        $data       = self::getFileData();
        $countries  = [Loc::getMessage('TFL_IBLOCK_LOCATION_RUSSIA')];

        foreach ($data as $location)
            if (isset($location[6]) && !in_array($location[6], $countries))
                $countries[] = $location[6];

        $countries = array_unique($countries);

        foreach ($countries as $country)
        {
            $countryCode    = \CUtil::translit($country, LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);
            $countryExists  = self::getCountryByCode($countryCode);

            if ($countryExists)
                continue;

            (new \CIBlockSection())->Add([
                'NAME'              => $country,
                'CODE'              => $countryCode,
                'XML_ID'            => $countryCode,
                'IBLOCK_ID'         => self::getId(),
                'IBLOCK_SECTION_ID' => false,
                'ACTIVE'            => 'Y',
                'TIMESTAMP_X'       => new DateTime()
            ]);
        }

        return true;
    }

    /**
     * @param $countryCode
     * @return array|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function getCountryByCode($countryCode)
    {
        return SectionTable::getRow([
            'filter' => ['=CODE' => $countryCode, '=IBLOCK_ID' => self::getId()],
            'select' => ['ID'],
            //'cache' => ['ttl' => 3600]
        ]);
    }

    /**
     * @param $regionCode
     * @param $countryId
     * @return array|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function getRegionByCodeCountryId($regionCode, $countryId)
    {
        return SectionTable::getRow([
            'filter'    => ['=CODE' => $regionCode, '=IBLOCK_SECTION_ID' => $countryId, '=IBLOCK_ID' => self::getId()],
            'select'    => ['ID'],
            //'cache'     => ['ttl' => 3600]
        ]);
    }

    /**
     * @param $locationCode
     * @param $regionId
     * @return array|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function getLocationByCodeRegionId($locationCode, $regionId)
    {
        return ElementTable::getRow([
            'filter'    => ['=CODE' => $locationCode, '=IBLOCK_SECTION_ID' => $regionId, '=IBLOCK_ID' => self::getId()],
            'select'    => ['ID'],
            //'cache'     => ['ttl' => 3600]
        ]);
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws ObjectException
     */
    public static function addRegions()
    {
        $data           = self::getFileData();
        $regionsNames   = [];
        $regions        = [];

        foreach ($data as $location)
            if (isset($location[2]) && !in_array($location[2], $regionsNames))
                $regions[] = $location;

        foreach ($regions as $region)
        {
            // check country
            $countryCode = isset($region[6])
                ? \CUtil::translit($region[6], LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-'])
                : \CUtil::translit(Loc::getMessage('TFL_IBLOCK_LOCATION_RUSSIA'), LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);

            $country = self::getCountryByCode($countryCode);

            if (!isset($country['ID']))
                continue;

            // check region
            $regionCode     = \CUtil::translit($region[2], LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);

            $regionExists   = self::getRegionByCodeCountryId($regionCode, $country['ID']);

            if ($regionExists)
                continue;

            (new \CIBlockSection())->Add([
                'NAME'              => $region[2],
                'CODE'              => $regionCode,
                'XML_ID'            => $regionCode,
                'IBLOCK_ID'         => self::getId(),
                'IBLOCK_SECTION_ID' => $country['ID'],
                'ACTIVE'            => 'Y',
                'TIMESTAMP_X'       => new DateTime()
            ]);
        }

        return true;
    }

    /**
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function addLocations()
    {
        $data = self::getFileData();

        foreach ($data as $location)
        {
            // check country
            $countryCode = isset($location[6])
                ? \CUtil::translit($location[6], LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-'])
                : \CUtil::translit(Loc::getMessage('TFL_IBLOCK_LOCATION_RUSSIA'), LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);

            $country = self::getCountryByCode($countryCode);

            if (!isset($country['ID']))
                continue;

            $regionCode     = \CUtil::translit($location[2], LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);
            $region   = self::getRegionByCodeCountryId($regionCode, $country['ID']);
            if (!isset($region['ID']))
                continue;

            $locationCode   = \CUtil::translit($location[1], LANGUAGE_ID, ['replace_space' => '-', 'replace_other' => '-']);

            $existsLocation = self::getLocationByCodeRegionId($locationCode, $region['ID']);
            if ($existsLocation)
                continue;

            (new \CIBlockElement())->Add([
                'NAME'  => $location[1],
                'CODE'  => $locationCode,
                'XML_ID'  => $locationCode,
                'IBLOCK_SECTION_ID' => $region['ID'],
                'IBLOCK_ID' => self::getId()
            ]);
        }

        return true;
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws ArgumentException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     */
    public static function createIblock()
    {
        if (self::getIblock()) return true;

        $id = self::create(self::CODE, Loc::getMessage('TFL_IBLOCK_LOCATION_NAME'), Loc::getMessage('TFL_IBLOCK_LOCATION_DESCRIPTION'));

        if (!$id) return false;

        Option::set('twofingers.location', self::OPTION_IBLOCK_ID, $id);

        return true;
    }
}