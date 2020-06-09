<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.11.2018
 * Time: 13:53
 *
 */
use \TWGeo\Location\Helper\Ip;
use \TWGeo\Location\Location\Internal;
use \TWGeo\Location\Location;
use \TWGeo\Location\Current;

/**
 * Class TWG_LOCATION_Location
 *
 * @deprecated
 */
class TWG_LOCATION_Location
{
    /** @var array */
    protected static $currentLocation;
    
    /**
     * @param mixed|string $langId
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @deprecated
     */
    public static function getCurrent($langId = LANGUAGE_ID)
    {
        if (is_null(self::$currentLocation))
        {
            self::$currentLocation = Current::getByIp(Ip::getCur());

            if (!empty(self::$currentLocation['city']['id'])) {

                $langId = trim($langId);
                if (!strlen($langId)) $langId = LANGUAGE_ID;

                $langId = strtolower($langId);

                self::$currentLocation['city_name'] = isset(self::$currentLocation['city']['name_' . $langId])
                    ? self::$currentLocation['city']['name_' . $langId]
                    : self::$currentLocation['city']['name_ru'];

                self::$currentLocation['sale_location_code'] = Location::getIdByName(self::$currentLocation['city_name'], $langId);

                self::$currentLocation['city_id'] = isset(self::$currentLocation['sale_location_code'])
                    ? self::$currentLocation['sale_location_code']
                    : self::$currentLocation['city']['id'];
            }
        }

        return self::$currentLocation;
    }

    /**
     * @param $id
     * @return mixed|null
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getCityNameById($id)
    {
        return Location::getNameById($id);
    }

    /**
     * @param $cityId
     * @return mixed|null
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getGeoCityNameById($cityId)
    {
        return Internal::getNameById($cityId);
    }

    /**
     * @param mixed|string $langId
     * @return mixed
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getCurrentCityName($langId = LANGUAGE_ID)
    {
        $location = self::getCurrent($langId);
        if (isset($location['city_name']))
            return $location['city_name'];

        return null;
    }

    /**
     * @param $sameNames
     * @return array|null
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getCitiesList()
    {
        try {
            $defaultCities = $sameNames = array();

            $cities = TWG_LOCATION_SaleLocation::getCitiesList($sameNames, $defaultCities);

            foreach ($sameNames as $name => $citiesIds){
                if (count($citiesIds) < 2) continue;

                foreach ($citiesIds as $cityId)
                    $cities[$cityId]['SHOW_REGION'] = 'Y';
            }

            return array(
                'CITIES'            => array_values($cities),
                'DEFAULT_CITIES'    => $defaultCities
            );

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param $sameNames
     * @param $defaultCities
     * @return array
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getGeoCitiesList(&$sameNames, &$defaultCities)
    {
        $cities         = Internal::getList();
        $defaultCities  = Internal::getDefaultList();
        $sameNames      = Internal::getSameNames($cities);

        return $cities;
    }
}