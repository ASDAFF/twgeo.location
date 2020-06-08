<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 10.11.2018
 * Time: 18:52
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */
use TwoFingers\Location\Location\Sale2;
use TwoFingers\Location\Location\Sale;
use \TwoFingers\Location\Location;

/**
 * Class TF_LOCATION_SaleLocation
 *
 * @author Pavel Shulaev (https://rover-it.me)
 * @deprecated
 */
class TF_LOCATION_SaleLocation
{
    /**
     * @return bool
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function is20()
    {
        return Location::getType() == Location::TYPE__SALE_2;
    }

    /**
     * @param string       $cityName
     * @param mixed|string $langId
     * @return null
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getId($cityName = '', $langId = LANGUAGE_ID)
    {
        if (!$cityName)
            $cityName = TF_LOCATION_Location::getCurrentCityName($langId);

        try {
            return (self::is20())
                ? Sale2::getIdByName($cityName, $langId)
                : Sale::getIdByName($cityName, $langId);

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param              $cityId
     * @param mixed|string $langId
     * @return null
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getName($cityId, $langId = LANGUAGE_ID)
    {
        return Location::getNameById($cityId, $langId);
    }

    /**
     * @param $sameNames
     * @param $defaultCities
     * @return array
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getCitiesList(&$sameNames, &$defaultCities)
    {
        try{
            $defaultCities  = Location::getDefaultList();
            $cities         = Location::getList();
            $sameNames      = Location::getSameNames($cities);

        } catch (\Exception $e) {
            $cities = $defaultCities = $sameNames = [];
        }

        return $cities;
    }

    /**
     * @return array|mixed|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getDefaultCities20()
    {
        return Sale2::getDefaultList();
    }

    /**
     * @return array|mixed|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function getCitiesList20()
    {
        return Sale2::getList();
    }

    /**
     * @param $sameNames
     * @param $defaultCities
     * @return array|mixed|null
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated ;
     */
    public static function getCitiesListOld(&$sameNames, &$defaultCities)
    {
        $cities         = Sale::getList();
        $defaultCities  = Sale::getDefaultList();
        $sameNames      = Sale::getSameNames($cities);

        return $cities;
    }
}