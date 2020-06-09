<?
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Class TWG_LOCATION_Helpers
 *
 * @author Pavel Shulaev (https://rover-it.me)
 * @deprecated
 */
class TWG_LOCATION_Helpers
{
    /**
     * @return mixed
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function GetRealIp()
    {
        return \TWGeo\Location\Helper\Ip::getCur();
    }
}
