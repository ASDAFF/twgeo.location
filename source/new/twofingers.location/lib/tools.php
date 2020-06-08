<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 05.02.2019
 * Time: 11:57
 *
 *
 */

namespace TwoFingers\Location;

use TwoFingers\Location\Helper\Ip;

/**
 * Class Tools
 *
 * @package TwoFingers\Location
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
        \TwoFingers\Location\Helper\Tools::translit($name, $langId);
    }
}