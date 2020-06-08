<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 16.12.2019
 * Time: 15:35
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

namespace TwoFingers\Location;

use TwoFingers\Location\Helper\Ip;
use TwoFingers\Location\Service\SxGeo;

class Service
{
    public static function getLocation($ip)
    {
        $ip = trim($ip);
        if (!Ip::isValid($ip))
            return [];

        return SxGeo::getLocation($ip);
    }

    public static function getMain()
    {

    }

    public static function getSecondary()
    {

    }
}