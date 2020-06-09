<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 11:57
 *
 *
 */

namespace TWGeo\Location;

use TWGeo\Location\Helper\Ip;

/**
 * Class Tools
 *
 * @package TWGeo\Location
 *
 * @deprecated
 */
class Tools
{
    /**
     * @return mixed
     *
     * @deprecated
     */
    public static function getRealIp()
    {
        return Ip::getCur();
    }

    /**
     * @param              $name
     * @param mixed|string $langId
     * @return string
     *
     * @deprecated
     */
    public static function translit($name, $langId = LANGUAGE_ID)
    {
        \TWGeo\Location\Helper\Tools::translit($name, $langId);
    }
}