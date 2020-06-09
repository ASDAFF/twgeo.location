<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 11:47
 *
 *
 */

namespace TWGeo\Location;

use Bitrix\Main\Loader;

/**
 * Class Location
 *
 * @package TWGeo\Location
 *
 */
class Location
{
    const TYPE__SALE        = 'sale';
    const TYPE__SALE_2      = 'sale2';
    const TYPE__INTERNAL    = 'internal';

    const CACHE_TTL         = 360000;

    /**
     * @return bool|string
     *
     */
    public static function getType()
    {
        try{
            if (Loader::includeModule('sale'))
                return method_exists('CSaleLocation','isLocationProMigrated')
                    && \CSaleLocation::isLocationProMigrated()
                    ? self::TYPE__SALE_2
                    : self::TYPE__SALE;

            return self::TYPE__INTERNAL;

        } catch (\Exception $e) {
            return self::TYPE__INTERNAL;
        }
    }

    /**
     * @return static|string|bool
     *
     */
    public static function getClassName()
    {
        $className = __NAMESPACE__ . '\Location\\' . self::getType();

        return class_exists($className) && is_subclass_of($className, __CLASS__) ? $className : false;
    }

    /**
     * @param $cities
     * @return array
     *
     *
     */
    public static function getSameNames($cities)
    {
        $sameNames = [];
        // setting the same cities
        foreach ($cities as $cityId => $city)
            $sameNames[$city['NAME']][] = $city['ID'];

        return $sameNames;
    }

    /**
     * @param $cities
     * @return mixed
     *
     */
    public static function markSameNames($cities)
    {
        $sameNames = self::getSameNames($cities);

        foreach ($sameNames as $name => $citiesIds){
            if (count($citiesIds) < 2) continue;

            foreach ($citiesIds as $cityId)
                $cities[$cityId]['SHOW_REGION'] = 'Y';
        }

        return $cities;
    }

    /**
     * @param              $cityName
     * @param mixed|string $langId
     * @return null
     *
     */
    public static function getIdByName($cityName, $langId = LANGUAGE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getIdByName'))
            return $className::getIdByName($cityName, $langId);

        return null;
    }

    /**
     * @param              $cityId
     * @param mixed|string $langId
     * @return null
     *
     */
    public static function getNameById($cityId, $langId = LANGUAGE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getNameById'))
            return $className::getNameById($cityId, $langId);

        return null;
    }

    /**
     * @param $locationId
     * @return null
     *
     */
    public static function getZipById($locationId)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getZipById'))
            return $className::getZipById($locationId);

        return null;
    }

    /**
     * @param string      $langId
     * @param bool|string $siteId
     * @return array
     *
     */
    public static function getDefaultList($langId = LANGUAGE_ID, $siteId = SITE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getDefaultList'))
            return $className::getDefaultList($langId, $siteId);

        return [];
    }

    /**
     * @param mixed|string $langId
     * @return array|null
     */
    public static function getDefault($langId = LANGUAGE_ID)
    {
         $className = self::getClassName();

        if ($className && method_exists($className, 'getDefault'))
            return $className::getDefault($langId);

        return null;
    }

    /**
     * @param mixed|string $langId
     * @return array
     *
     */
    public static function getList($langId = LANGUAGE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getList'))
            return $className::getList($langId);

        return [];
    }

    /**
     * @param        $q
     * @param string $langId
     * @return array
     *
     */
    public static function find($q, $langId = LANGUAGE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'find'))
        {
            $locations = $className::find($q, $langId);

            foreach ($locations as &$location)
                $location['NAME'] = htmlspecialcharsEx(preg_replace('#(' . $q .')#is', '<b>$1</b>', $location['NAME']));

            return $locations;
        }

        return [];
    }

    /**
     * @param string $langId
     * @return array
     *
     */
    public static function getCitiesList($langId = LANGUAGE_ID)
    {
        $className = self::getClassName();

        if ($className && method_exists($className, 'getCitiesList'))
            return $className::getCitiesList($langId);

        return self::getList($langId);
    }
}