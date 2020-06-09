<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 08.07.2017
 * Time: 14:18
 *
 *
 */

namespace TWGeo\Location\Helper;

use Bitrix\Main\Application;

/**
 * Class Ip
 *
 * @package Rover\GeoIp\Service
 *
 */
class Ip
{
    /**
     * @return bool|mixed
     *
     */
    public static function getCur()
    {
        $ips = array();
        try{
            $server = Application::getInstance()
                ->getContext()->getServer();

            if ($server->get('HTTP_X_FORWARDED_FOR'))
                $ips[] = trim(strtok($server->get('HTTP_X_FORWARDED_FOR'), ','));

            if ($server->get('HTTP_CLIENT_IP'))
                $ips[] = $server->get('HTTP_CLIENT_IP');

            if ($server->get('REMOTE_ADDR'))
                $ips[] = $server->get('REMOTE_ADDR');

            if ($server->get('HTTP_X_REAL_IP'))
                $ips[] = $server->get('HTTP_X_REAL_IP');

            foreach($ips as $ip)
                if(self::isValid($ip))
                    return $ip;

        } catch (\Exception $e) {}

        return false;
    }

    /**
     * @param $ip
     * @return bool
     *
     */
    public static function isV4($ip)
    {
        return (bool)preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip);
    }

    /**
     * @param $ip
     * @return bool
     *
     */
    public static function isV6($ip)
    {
        return (bool)preg_match("#((^|:)([0-9a-fA-F]{0,4})){1,8}$#", $ip);
    }

    /**
     * @param $ip
     * @return bool
     *
     */
    public static function isValid($ip)
    {
        return self::isV4($ip) || self::isV6($ip);
    }
}