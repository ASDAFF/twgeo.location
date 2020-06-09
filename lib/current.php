<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.03.2019
 * Time: 16:04
 *
 *
 */

namespace TWGeo\Location;

use Bitrix\Main\ArgumentOutOfRangeException;
use TWGeo\Location\Helper\Ip;
use \Bitrix\Main;
/**
 * Class Current
 *
 * @package TWGeo\Location
 *
 */
class Current
{
    /** @var array  */
    protected static $instances = [];

    /** @var string */
    protected $ip;

    /** @var string */
    protected $langId;

    /** @var array */
    protected $location;

    /** @var string */
    protected $saleLocationCode;

    /** @var string */
    protected $saleRegionCode;

    /** @var string */
    protected $saleCountryCode;

    /**
     * Current constructor.
     *
     * @param              $ip
     * @param mixed|string $langId
     * @throws ArgumentOutOfRangeException
     */
    public function __construct($ip, $langId = LANGUAGE_ID)
    {
        if (!Ip::isValid($ip))
            throw new ArgumentOutOfRangeException('ip');

        $this->ip       = $ip;
        $this->langId   = trim($langId);
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getSaleLocationCode($langId = null, $reload = false)
    {
        if (empty($this->saleLocationCode) || $reload)
            $this->saleLocationCode = self::getSaleCodeByName($this->getLocationName($langId, $reload), $langId);

        return $this->saleLocationCode;
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getSaleRegionCode($langId = null, $reload = false)
    {
        if (empty($this->saleRegionCode) || $reload)
            $this->saleRegionCode = self::getSaleCodeByName($this->getRegionName($langId, $reload), $langId);

        return $this->saleRegionCode;
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getSaleCountryCode($langId = null, $reload = false)
    {
        if (empty($this->saleCountryCode) || $reload)
            $this->saleCountryCode = self::getSaleCodeByName($this->getCountryName($langId, $reload), $langId);

        return $this->saleCountryCode;
    }

    /**
     * @param      $name
     * @param null $langId
     * @return null
     *
     */
    protected function getSaleCodeByName($name, $langId = null)
    {
        if (empty($langId))
            $langId = $this->getLangId();

        $name = trim($name);
        if (!strlen($name)) return null;

        return Location::getIdByName($name, $langId);
    }

    /**
     * @param null         $ip
     * @param mixed|string $langId
     * @return self
     *
     */
    public static function getInstance($ip = null, $langId = LANGUAGE_ID)
    {
        if (is_null($ip))
            $ip = Ip::getCur();

        $langId = trim($langId);

        if (!isset(self::$instances[$ip . $langId]))
            try{
                self::$instances[$ip . $langId] = new self($ip);
            } catch (\Exception $e) {
                return null;
            }

        return self::$instances[$ip . $langId];
    }

    /**
     * @param bool $reload
     * @return array
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getLocation($reload = false)
    {
        if (!$this->isLoaded() || $reload)
            $this->load();

        return $this->location;
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed|string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getLocationId($langId = null, $reload = false)
    {
        $saleLocationCode = $this->getSaleLocationCode($langId, $reload);
        if (strlen($saleLocationCode))
            return $saleLocationCode;

        return $this->getCityId($reload);
    }

    /**
     * @param bool $reload
     * @return mixed|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getCityId($reload = false)
    {
        $location = $this->getLocation($reload);

        return !empty($location['city']['id']) ? $location['city']['id'] : null;
    }


    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed|string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getRegionId($langId = null, $reload = false)
    {
        $saleRegionCode = $this->getSaleRegionCode($langId, $reload);
        if (strlen($saleRegionCode))
            return $saleRegionCode;

        $location = $this->getLocation($reload);

        return !empty($location['region']['id']) ? $location['region']['id'] : null;
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed|string|null
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getCountryId($langId = null, $reload = false)
    {
        $saleCountryCode = $this->getSaleCountryCode($langId, $reload);
        if (strlen($saleCountryCode))
            return $saleCountryCode;

        $location = $this->getLocation($reload);

        return !empty($location['country']['id']) ? $location['country']['id'] : null;
    }

    /**
     * @param bool $reload
     * @return bool
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     *
     */
    public function isDefined($reload = false)
    {
        if (!$this->isLoaded() || $reload)
            $this->load();

        return $this->isLoaded();
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getLocationName($langId = null, $reload = false)
    {
        return $this->getCityName($langId, $reload);
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getCityName($langId = null, $reload = false)
    {
        if (empty($langId))
            $langId = $this->getLangId();

        $langId     = strtolower($langId);
        $location   = $this->getLocation($reload);

        return !empty($location['city']['name_' . $langId])
            ? $location['city']['name_' . $langId]
            : $location['city']['name_ru'];
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getRegionName($langId = null, $reload = false)
    {
        if (empty($langId))
            $langId = $this->getLangId();

        $langId     = strtolower($langId);
        $location   = $this->getLocation($reload);

        return !empty($location['region']['name_' . $langId])
            ? $location['region']['name_' . $langId]
            : $location['region']['name_ru'];
    }

    /**
     * @param null $langId
     * @param bool $reload
     * @return mixed
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     */
    public function getCountryName($langId = null, $reload = false)
    {
        if (empty($langId))
            $langId = $this->getLangId();

        $langId     = strtolower($langId);
        $location   = $this->getLocation($reload);

        return !empty($location['country']['name_' . $langId])
            ? $location['country']['name_' . $langId]
            : $location['country']['name_ru'];
    }

    /**
     * @return bool
     *
     */
    protected function isLoaded()
    {
        return (bool)$this->location;
    }

    /**
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     *
     */
    protected function load()
    {
        $this->location = self::getByIp($this->getIp());
    }

    /**
     * @param $ip
     * @return array
     * @throws ArgumentOutOfRangeException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentNullException
     *
     */
    public static function getByIp($ip)
    {
        $location = Service::getLocation($ip);

        if (!empty($location['city']['id'])) {

            $location['city']['name_ru']   = mb_convert_encoding($location['city']['name_ru'], LANG_CHARSET, 'UTF-8');
            $location['region']['name_ru'] = mb_convert_encoding($location['region']['name_ru'], LANG_CHARSET, 'UTF-8');
            $location['country']['name_ru']= mb_convert_encoding($location['country']['name_ru'], LANG_CHARSET, 'UTF-8');
        }

        return $location;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return string
     */
    public function getLangId()
    {
        return $this->langId;
    }
}