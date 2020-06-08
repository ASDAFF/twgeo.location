<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 11:46
 *
 *
 */

namespace TwoFingers\Location\Location;

use TwoFingers\Location\Location,
    Bitrix\Main\Loader,
    TwoFingers\Location\Helper\Tools,
    TwoFingers\Location\Settings,
    \Bitrix\Main\Application;

/**
 * Class Sale
 *
 * @package TwoFingers\Location\Location
 *
 */
class Sale extends Location
{
    /**
     * @param              $cityName
     * @param mixed|string $langId
     * @return mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getIdByName($cityName, $langId = LANGUAGE_ID)
    {
        if (!Loader::IncludeModule('sale'))
            return null;

        $cityName = trim($cityName);
        if (!strlen($cityName)) return null;

        $cacheId    = md5(__METHOD__ . $cityName . $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $saleLocation = \CSaleLocation::GetList(
            array("CITY_NAME"=>"ASC"),
            array("LID" => $langId, 'CITY_NAME' => $cityName),
            false,
            false,
            array('ID')
        )->Fetch();

        if (!isset($saleLocation['ID']))
            return null;

        $cache->set($cacheId, $saleLocation['ID']);

        return $saleLocation['ID'];
    }

    /**
     * @param              $cityId
     * @param mixed|string $langId
     * @return mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getNameById($cityId, $langId = LANGUAGE_ID)
    {
        if (!Loader::IncludeModule('sale'))
            return null;

        $cityId = trim($cityId);
        if (!strlen($cityId))
            return null;

        $cacheId    = md5(__METHOD__ . $cityId . $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $saleLocation = \CSaleLocation::GetList(
            array("CITY_NAME" => "ASC"),
            array("LID" => $langId, 'ID' => $cityId),
            false,
            false,
            array('CITY_NAME')
        )->Fetch();

        if (!isset($saleLocation['CITY_NAME']))
            return null;

        $cache->set($cacheId, $saleLocation['CITY_NAME']);

        return $saleLocation['CITY_NAME'];
    }


    /**
     * @param string      $langId
     * @param bool|string $siteId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getDefaultList($langId = LANGUAGE_ID, $siteId = SITE_ID)
    {
        $cities         = self::getList($langId);
        $defaultCities  = Settings::get('TF_LOCATION_DEFAULT_CITIES');
        $result         = [];

        foreach ($cities as $city)
            if(in_array($city['ID'], $defaultCities))
                $result[] = [
                    'NAME'      => htmlspecialcharsEx($city['NAME']),
                    'TRANSLIT'  => Tools::translit($city['LANME'], $langId),
                    'ID'        => $city['ID']
                ];

        return $result;
    }

    /**
     * @param        $q
     * @param string $langId
     * @return array|bool|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function find($q, $langId = LANGUAGE_ID)
    {
        $filter = [
            '>=CITY_NAME' => $q,
            '%CITY_NAME' => $q,
            'LID'       => $langId
        ];


        return self::getByFilter($filter);
    }

    /**
     * @param $filter
     * @return bool|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getByFilter($filter)
    {
        if (!Loader::includeModule('sale'))
            return null;

        $cacheId    = md5(__METHOD__ . serialize($filter));
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $db_vars = \CSaleLocation::GetList(array("CITY_NAME_LANG"=>"ASC"),
            $filter,
            false,
            false,
            array(
                'ID',
                'CITY_ID',
                'CITY_NAME',
                'REGION_NAME',
                'REGION_ID',
                'COUNTRY_ID',
                'COUNTRY_NAME'
            ));

        $cities     = [];
        $langId = isset($filter['LID']) ? $filter['LID'] : LANGUAGE_ID;

        while ($vars = $db_vars->Fetch()) {

            if (empty($vars['CITY_ID']))
                continue;

            $city = Array(
                'NAME'          => htmlspecialcharsEx($vars['CITY_NAME']),
                'ID'            => $vars['ID'],
                'TRANSLIT'      => Tools::translit($vars['CITY_NAME'], $langId),
                'REGION_NAME'   => $vars['REGION_NAME'],
                'REGION_ID'     => $vars['REGION_ID'],
                'COUNTRY_NAME'  => $vars['COUNTRY_NAME'],
                'COUNTRY_ID'    => $vars['COUNTRY_ID'],
                'SHOW_REGION'   => 'N'
            );

            $cities[$vars['ID']] = $city;
        }

        $cache->set($cacheId, $cities);

        return $cities;
    }

    /**
     * @param mixed|string $langId
     * @return array|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getList($langId = LANGUAGE_ID)
    {
        return self::getByFilter(['LID' => $langId]);
    }

    /**
     * @param $locationId
     * @return array|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getZipById($locationId)
    {
        if (!Loader::includeModule('sale'))
            return null;

        $cacheId    = md5(__METHOD__ . $locationId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $rsZip      = \CSaleLocation::GetLocationZIP($locationId);
        $arResult   = [];
        while ($arZip = $rsZip->fetch())
            $arResult[] = $arZip['ZIP'];

        $cache->set($cacheId, $arResult);

        return $arResult;
    }
}