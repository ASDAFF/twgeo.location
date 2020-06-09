<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.03.2019
 * Time: 16:28
 *
 * 
 */

namespace TWGeo\Location\Storage;

use TWGeo\Location\Storage;
use Bitrix\Main\ArgumentNullException;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\ArgumentOutOfRangeException;
/**
 * Class SessionStorage
 *
 * @package TWGeo\Location
 *
 * @deprecated
 */
class Session extends Storage
{
    /**
     * @return bool
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function isEmpty()
    {
        return parent::isEmpty(self::TYPE__SESSION);
    }

    /**
     * @param $current
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setFromCurrent($current)
    {
        return parent::setFromCurrent($current, self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function get()
    {
        return parent::get(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getLocationId()
    {
        return parent::getLocationId(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getLocationName()
    {
        return parent::getLocationName(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getRegionId()
    {
        return parent::getRegionId(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getRegionName()
    {
        return parent::getRegionName(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getCountryId()
    {
        return parent::getCountryId(self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getCountryName()
    {
        return parent::getCountryName(self::TYPE__SESSION);
    }

    /**
     * @param $id
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setLocationId($id)
    {
        parent::setLocationId($id, self::TYPE__SESSION);
    }

    /**
     * @param $name
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setLocationName($name)
    {
        parent::setLocationName($name, self::TYPE__SESSION);
    }

    /**
     * @param $id
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setRegionId($id)
    {
        parent::setRegionId($id, self::TYPE__SESSION);
    }

    /**
     * @param $name
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setRegionName($name)
    {
        parent::setRegionName($name, self::TYPE__SESSION);
    }

    /**
     * @param $id
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setCountryId($id)
    {
        parent::setCountryId($id, self::TYPE__SESSION);
    }

    /**
     * @param $name
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setCountryName($name)
    {
        parent::setCountryName($name, self::TYPE__SESSION);
    }

    /**
     * 
     * @deprecated
     */
    public static function clear()
    {
        parent::clear(self::TYPE__SESSION);
    }

    /**
     * @param $status
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function setConfirmPopupClosedByUser($status)
    {
        parent::setConfirmPopupClosedByUser($status, self::TYPE__SESSION);
    }

    /**
     * @return mixed|null
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * 
     * @deprecated
     */
    public static function getConfirmPopupClosedByUser()
    {
        return parent::getConfirmPopupClosedByUser(self::TYPE__SESSION);
    }
}