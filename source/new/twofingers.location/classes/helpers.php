<?

/**
 * Class TF_LOCATION_Helpers
 *
 * @author Pavel Shulaev (https://rover-it.me)
 * @deprecated
 */
class TF_LOCATION_Helpers
{
    /**
     * @return mixed
     * @author Pavel Shulaev (https://rover-it.me)
     * @deprecated
     */
    public static function GetRealIp()
    {
        return \TwoFingers\Location\Helper\Ip::getCur();
    }
}
