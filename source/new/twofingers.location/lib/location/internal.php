<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 12:33
 *
 *
 */

namespace TwoFingers\Location\Location;

use Bitrix\Iblock\SectionTable;
use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\SystemException;
use TwoFingers\Location\Location;
use TwoFingers\Location\Helper\Tools;

/**
 * Class Internal
 *
 * @package TwoFingers\Location\Location
 *
 */
class Internal extends Location
{
    /**
     * @param mixed|string $langId
     * @return array|bool|mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getList($langId = LANGUAGE_ID)
    {
        $filter = [
            'IBLOCK_ID' => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'    => 'Y'
        ];

        return self::getByFilter($filter, $langId);
    }

    /**
     * @param array        $filter
     * @param mixed|string $langId
     * @return array|bool|mixed|null
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getByFilter(array $filter = [], $langId = LANGUAGE_ID)
    {
        if (!Loader::IncludeModule('iblock'))
            return null;

        $cacheId    = md5(__METHOD__ . serialize($filter) . $langId);
        $cache      = Application::getInstance()->getManagedCache();
        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $elements   = \CIBlockElement::GetList(['NAME'=> 'ASC'], $filter, false, false, ['*', 'PROPERTY_FEATURES', 'PROPERTY_DEFAULT']);
        $locations  = [];

        while ($element = $elements->Fetch())
        {
            $region = SectionTable::getRow([
                'filter' => ['=ID' => $element['IBLOCK_SECTION_ID']],
                'select' => ['ID', 'NAME', 'PARENT_ID' => 'PARENT_SECTION.ID', 'PARENT_NAME' => 'PARENT_SECTION.NAME']
            ]);

            $location = [
                'NAME'          => $element['NAME'],
                'ID'            => $element['ID'],
                'REGION_NAME'   => $region['NAME'],
                'REGION_ID'     => $region['ID'],
                'REGION_CODE'   => $region['ID'],
                'COUNTRY_NAME'  => $region['PARENT_NAME'],
                'COUNTRY_ID'    => $region['PARENT_ID'],
                'TRANSLIT'      => Tools::translit($element['NAME'], $langId),
                'SHOW_REGION'   => 'N'
            ];

            $locations[$location['ID']] = $location;
        }

        $cache->set($cacheId, $locations);

        return $locations;
    }

    /**
     * @param              $q
     * @param mixed|string $langId
     * @return array|bool|mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function find($q, $langId = LANGUAGE_ID)
    {
        $filter = [
            'IBLOCK_ID' => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'    => 'Y',
            '%NAME'     => $q
        ];

        return self::getByFilter($filter, $langId);
    }

    /**
     * @param mixed|string            $langId
     * @param bool|false|mixed|string $siteId
     * @return array|bool|mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getDefaultList($langId = LANGUAGE_ID, $siteId = SITE_ID)
    {
        $filter = [
            'IBLOCK_ID'             => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'                => 'Y',
            '!PROPERTY_FEATURED'    => false
        ];

        return self::getByFilter($filter, $langId);
    }

    /**
     * @param mixed|string $langId
     * @return array|mixed|null
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getDefault($langId = LANGUAGE_ID)
    {
        $filter = [
            'IBLOCK_ID'             => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'                => 'Y',
            '!PROPERTY_DEFAULT'    => false
        ];

        $default = self::getByFilter($filter, $langId);
        if ($default)
            return reset($default);

        return null;
    }

    /**
     * @param              $cityId
     * @param mixed|string $langId
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getNameById($cityId, $langId = LANGUAGE_ID)
    {
        $cityId = intval($cityId);
        if (!$cityId)
            return null;

        $filter = [
            'IBLOCK_ID' => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'    => 'Y',
            'ID'        => $cityId
        ];

        $list = self::getByFilter($filter, $langId);
        if (isset($list[$cityId]['NAME']))
            return $list[$cityId]['NAME'];

        return null;
    }

    /**
     * @param              $cityName
     * @param mixed|string $langId
     * @return |null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws LoaderException
     * @throws SystemException
     */
    public static function getIdByName($cityName, $langId = LANGUAGE_ID)
    {
        $cityName = trim($cityName);
        if (!strlen($cityName))
            return null;

        $filter = [
            'IBLOCK_ID' => \TwoFingers\Location\Iblock\Location::getId(),
            'ACTIVE'    => 'Y',
            'NAME'      => $cityName
        ];

        $list = self::getByFilter($filter, $langId);
        if (empty($list))
            return null;

        $element = reset($list);
        return isset($element['NAME'])
            ? $element['NAME']
            : null;
    }

    /**
     * @param $locationId
     * @return null
     *
     */
    public static function getZipById($locationId)
    {
        return null;
    }
}