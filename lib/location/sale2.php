<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 12:02
 *
 * 
 */

namespace TWGeo\Location\Location;

use Bitrix\Sale\Location\DefaultSiteTable;
use Bitrix\Sale\Location\LocationTable;
use TWGeo\Location\Location;
use Bitrix\Main\Loader;
use TWGeo\Location\Helper\Tools;
use Bitrix\Main\Application;
use TWGeo\Location\Settings;
use \Bitrix\Main;
/**
 * Class Sale2
 *
 * @package TWGeo\Location\Location
 *
 */
class Sale2 extends Location
{
    /**
     * @param              $cityName
     * @param mixed|string $langId
     * @return bool|mixed|null
     * @throws Main\LoaderException
     * @throws Main\SystemException
     * 
     */
    public static function getIdByName($cityName, $langId = LANGUAGE_ID)
    {
        if (!Loader::includeModule('sale'))
            return null;

        $cityName = trim($cityName);
        if (!strlen($cityName))
            return null;

        $cacheId    = md5(__METHOD__ . $cityName . $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $query = array(
            'filter' => array(
                '=NAME.LANGUAGE_ID' => $langId,
                '=NAME.NAME'        => $cityName
            ),
            'select' => array('CODE')
        );

        $result = LocationTable::getRow($query);
        if (!isset($result['CODE']))
            return null;

        $cache->set($cacheId, $result['CODE']);

        return $result['CODE'];
    }

    /**
     * @param mixed|string $langId
     * @return array|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     */
    public static function getDefault($langId = LANGUAGE_ID)
    {
        $defaultId = Settings::get('TWG_LOCATION_DEFAULT_CITY');
        if (!$defaultId)
            return null;

        $filter = [
            '=NAME.LANGUAGE_ID' => $langId,
            '=ID'               => $defaultId,
        ];

        $default = self::getByFilter($filter);
        if ($default)
            return reset($default);

        return null;
    }

    /**
     * @param              $locationCode
     * @param mixed|string $langId
     * @return bool|mixed|null
     * @throws Main\LoaderException
     * @throws Main\SystemException
     * 
     */
    public static function getNameById($locationCode, $langId = LANGUAGE_ID)
    {
        if (!Loader::IncludeModule('sale'))
            return null;

        $locationCode = trim($locationCode);
        if (!strlen($locationCode))
            return null;

        $cacheId    = md5(__METHOD__ . $locationCode . $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $query = array(
            'filter' => array(
                '=NAME.LANGUAGE_ID' => $langId,
                '=CODE'             => $locationCode
            ),
            'select' => array('LNAME' => 'NAME.NAME')
        );

        $result = LocationTable::getRow($query);

        if (!isset($result['LNAME']))
            return null;

        $cache->set($cacheId, $result['LNAME']);

        return $result['LNAME'];
    }

    /**
     * @param string      $langId
     * @param bool|string $siteId
     * @return array|bool|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * 
     */
    public static function getDefaultList($langId = LANGUAGE_ID, $siteId = SITE_ID)
    {
        if (!Loader::IncludeModule('sale'))
            return null;

        $cacheId    = md5(__METHOD__ . $langId . $siteId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        // default
        $res = DefaultSiteTable::getList(array(
            'filter' => array(
                'SITE_ID'                   => $siteId,
                'LOCATION.NAME.LANGUAGE_ID' => $langId
            ),
            'order' => array(
                'SORT' => 'asc'
            ),
            'select' => array(
                'CODE'      => 'LOCATION.CODE',
                'ID'        => 'LOCATION.ID',
                'NAME'      => 'LOCATION.NAME.NAME',
            )
        ));

        $defaults = [];
        while($item = $res->Fetch())
        {
             $location = Array(
                'NAME'      => htmlspecialcharsEx($item['NAME']),
                'TRANSLIT'  => Tools::translit($item['NAME'], $langId),
                'ID'        => $item['CODE'], // @deprecated
                'CODE'      => $item['CODE'],
                'SHOW_REGION' => 'N',
            );

            $location = self::addTreeInfo($location);

            $defaults[] = $location;
        }

        $cache->set($cacheId, $defaults);

        return $defaults;
    }

    /**
     * @param array $filter
     * @return array|bool|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * 
     */
    public static function getByFilter(array $filter = [])
    {
        if (!Loader::IncludeModule('sale'))
            return null;

        $cacheId        = md5(__METHOD__ . serialize($filter));
        $cache          = Application::getInstance()->getManagedCache();
        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $langId = isset($filter['=NAME.LANGUAGE_ID']) ? $filter['=NAME.LANGUAGE_ID'] : LANGUAGE_ID;
        $query = array(
            'filter'    => $filter,
            'select'    => ['ID', 'CODE', 'LEFT_MARGIN', 'RIGHT_MARGIN', 'LNAME' => 'NAME.NAME'],
            'order'     => ['LNAME' => 'asc']
        );

        $dbResult   = LocationTable::getList($query);
        $locations  = array();

        while ($item = $dbResult->fetch())
        {
            $location = Array(
                'NAME'          => htmlspecialcharsEx($item['LNAME']),
                'ID'            => $item['CODE'], // @deprecated
                'CODE'          => $item['CODE'],
                'TRANSLIT'      => Tools::translit($item['LNAME'], $langId),
                'SHOW_REGION'   => 'N'
            );

            $location = self::addTreeInfo($location);

            $locations[$location['ID']] = $location;
        }

        $cache->set($cacheId, $locations);

        return $locations;
    }

    /**
     * @param mixed|string $langId
     * @return array|bool|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * 
     */
    public static function getList($langId = LANGUAGE_ID)
    {
        $code = ['CITY'];
        if (Settings::get('TWG_LOCATION_SHOW_VILLAGES') === 'Y')
            $code[] = 'VILLAGE';

        $filter = [
            '=NAME.LANGUAGE_ID' => $langId,
            '=TYPE.CODE'        => $code,
        ];

        return self::getByFilter($filter);
    }

    /**
     * @param string $langId
     * @return array|bool|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * 
     */
    public static function getCitiesList($langId = LANGUAGE_ID)
    {
        $filter = [
            '=NAME.LANGUAGE_ID' => $langId,
            '=TYPE.CODE'        => ['CITY'],
        ];

        return self::getByFilter($filter);
    }

    /**
     * @param        $q
     * @param string $langId
     * @return array|bool|mixed|null
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * 
     */
    public static function find($q, $langId = LANGUAGE_ID)
    {
        $code = ['CITY'];
        if (Settings::get('TWG_LOCATION_SHOW_VILLAGES') === 'Y')
            $code[] = 'VILLAGE';

        $filter = [
            '=NAME.LANGUAGE_ID' => $langId,
            '=TYPE.CODE'        => $code,
            '>=LNAME'           => $q,
            '%LNAME'            => $q
        ];

        return self::getByFilter($filter);
    }

    /**
     * @param $itemId
     * @param $location
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * 
     */
    protected static function addTreeInfo($location)
    {
        if (empty($location['CODE'])) return [];

        $tree = self::getTree($location['CODE']);
        foreach ($tree as $branch)
        {
            switch ($branch['I_TYPE']){
                case 'REGION':
                    $location['REGION_NAME']    = $branch['I_NAME'];
                    $location['REGION_ID']      = $branch['I_CODE'];
                    $location['REGION_CODE']    = $branch['I_CODE'];
                    break;
                case 'COUNTRY':
                    $location['COUNTRY_NAME']   = $branch['I_NAME'];
                    $location['COUNTRY_ID']     = $branch['I_CODE'];
                    $location['COUNTRY_CODE']   = $branch['I_CODE'];
                    break;
            }
        }

        return $location;
    }

    /**
     * @param              $locationCode
     * @param mixed|string $langId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * 
     */
    public static function getTree($locationCode, $langId = LANGUAGE_ID)
    {
        $cacheId    = md5(__METHOD__ . $locationCode . $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $res = LocationTable::getList(array(
            'filter' => array(
                '=CODE'                             => $locationCode,
                '=PARENTS.NAME.LANGUAGE_ID'         => $langId,
                '=PARENTS.TYPE.NAME.LANGUAGE_ID'    => $langId,
                '=PARENTS.TYPE.CODE'                => ['REGION', 'COUNTRY']
            ),
            'select' => array(
                'I_ID'      => 'PARENTS.ID',
                'I_CODE'    => 'PARENTS.CODE',
                'I_NAME'    => 'PARENTS.NAME.NAME',
                'I_TYPE'    => 'PARENTS.TYPE.CODE',
              //  'I_TYPE_NAME_RU' => 'PARENTS.TYPE.NAME.NAME'
            ),
            'order' => array(
                'PARENTS.DEPTH_LEVEL' => 'asc'
            )
        ));

        $tree = [];

        while($item = $res->fetch())
            $tree[] = $item;

        $cache->set($cacheId, $tree);

        return $tree;
    }

    /**
     * @param $locationCode
     * @return array|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     * 
     */
    public static function getZipById($locationCode)
    {
        $locationId = self::getIdByCode($locationCode);

        return Sale::getZipById($locationId);
    }

    /**
     * @param              $locationCode
     * @param mixed|string $langId
     * @return mixed|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * 
     */
    protected static function getIdByCode($locationCode, $langId = LANGUAGE_ID)
    {
        if (!Loader::includeModule('sale'))
            return null;

        $cacheId    = md5(__METHOD__ . $locationCode, $langId);
        $cache      = Application::getInstance()->getManagedCache();

        if ($cache->read(self::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $query = array(
            'filter' => array(
                '=NAME.LANGUAGE_ID' => $langId,
                '=CODE'             => $locationCode
            ),
            'select' => array('ID')
        );

        $result = LocationTable::getRow($query);

        if (!isset($result['ID']))
            return null;

        $cache->set($cacheId, $result['ID']);

        return $result['ID'];
    }
}