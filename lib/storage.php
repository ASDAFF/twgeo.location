<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 12.07.2019
 * Time: 15:47
 *
 *
 */

namespace TWGeo\Location;

use Bitrix\Main\ArgumentNullException;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\ArgumentOutOfRangeException;

/**
 * Class Storage
 *
 * @package TWGeo\Location
 *
 */
class Storage
{
    const TYPE__COOKIE  = 'cookie';
    const TYPE__SESSION = 'session';

    /**
     * @param null $driver
     * @return bool
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function isEmpty($driver = null)
    {
        return empty(self::getLocationId($driver));
    }

    /**
     * @param      $current
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setFromCurrent($current, $driver = null)
    {
        if (($current instanceof Current) && $current->isDefined())
        {
            self::setByKey('city_id', $current->getLocationId(), $driver);
            self::setByKey('city_name', $current->getLocationName(), $driver);
            self::setByKey('region_id', $current->getRegionId(), $driver);
            self::setByKey('region_name', $current->getRegionName(), $driver);
            self::setByKey('country_id', $current->getCountryId(), $driver);
            self::setByKey('country_name', $current->getCountryName(), $driver);
            self::setNeedCheck('Y');
        }
    }

    /**
     * @param      $value
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function setNeedCheck($value, $driver = null)
    {
        self::setByKey('need_check', $value, $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function getNeedCheck($driver = null)
    {
        return self::getByKey('need_check', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function get($driver = null)
    {
        return self::getByKey('', $driver);
    }

    /**
     * @param      $key
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getByKey($key, $driver = null)
    {
        $key = trim($key);

        if (is_null($driver))
            $driver = self::getDriver();

        if ($driver == self::TYPE__COOKIE)
            $data = $_COOKIE['TWG_LOCATION'];
        else
            $data = $_SESSION['TWG_LOCATION'];

        if (strlen($key))
            return array_key_exists($key, $data)
                ? $data[$key]
                : null;

        return $data;
    }

    /**
     * @param      $key
     * @param      $value
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setByKey($key, $value, $driver = null)
    {
        $key = trim($key);
        if (!strlen($key))
            throw new ArgumentNullException('key');

        if (is_null($driver))
            $driver = self::getDriver();

        if ($driver == self::TYPE__COOKIE){
            $lifetime = intval(Settings::get('TWG_LOCATION_COOKIE_LIFETIME'));
            setcookie('TWG_LOCATION[' . $key . ']', $value, time() + 60 * 60 * 24 * $lifetime, '/');
            $_COOKIE['TWG_LOCATION'][$key] = $value;
        } else {
            $_SESSION['TWG_LOCATION'][$key] = $value;
        }
    }

    /**
     * @return string
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    protected static function getDriver()
    {
        $lifetime = Settings::get('TWG_LOCATION_COOKIE_LIFETIME');

        return $lifetime > 0 ? self::TYPE__COOKIE : self::TYPE__SESSION;
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getLocationId($driver = null)
    {
        return self::getByKey('city_id', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getLocationName($driver = null)
    {
        return self::getByKey('city_name', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getRegionId($driver = null)
    {
        return self::getByKey('region_id', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getRegionName($driver = null)
    {
        return self::getByKey('region_name', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getCountryId($driver = null)
    {
        return self::getByKey('country_id', $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getCountryName($driver = null)
    {
        return self::getByKey('country_name', $driver);
    }

    /**
     * @param      $id
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setLocationId($id, $driver = null)
    {
        self::setByKey('city_id', $id, $driver);
    }

    /**
     * @param      $name
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setLocationName($name, $driver = null)
    {
        self::setByKey('city_name', $name, $driver);
    }

    /**
     * @param      $id
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setRegionId($id, $driver = null)
    {
        self::setByKey('region_id', $id, $driver);
    }

    /**
     * @param      $name
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setRegionName($name, $driver = null)
    {
        self::setByKey('region_name', $name, $driver);
    }

    /**
     * @param      $id
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setCountryId($id, $driver = null)
    {
        self::setByKey('country_id', $id, $driver);
    }

    /**
     * @param      $name
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setCountryName($name, $driver = null)
    {
        self::setByKey('country_name', $name, $driver);
    }

    /**
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function clear($driver = null)
    {
        if (is_null($driver))
            $driver = self::getDriver();

        if ($driver == self::TYPE__COOKIE){
            if (isset($_COOKIE['TWG_LOCATION'])){
                foreach ($_COOKIE['TWG_LOCATION'] as $key => $value){
                    unset($_COOKIE['TWG_LOCATION'][$key]);
                    setcookie('TWG_LOCATION[' . $key . ']', $value, time() - 60 * 60 * 24 * 7, '/');
                }
            }
        } else {
            unset($_SESSION['TWG_LOCATION']);
        }
    }

    /**
     * @param      $status
     * @param null $driver
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function setConfirmPopupClosedByUser($status, $driver = null)
    {
        if ($status != 'Y')
            $status = 'N';

        self::setByKey('confirm_popup_closed_by_user', $status, $driver);
    }

    /**
     * @param null $driver
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     *
     */
    public static function getConfirmPopupClosedByUser($driver = null)
    {
        return self::getByKey('confirm_popup_closed_by_user', $driver);
    }
}