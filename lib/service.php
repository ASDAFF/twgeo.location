<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: �����
 * Date: 16.12.2019
 * Time: 15:35
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

namespace TWGeo\Location;

use TWGeo\Location\Helper\Ip;
use TWGeo\Location\Service\SxGeo;

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