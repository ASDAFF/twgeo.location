<?

use \TwoFingers\Location\Settings;

/**
 * Class TF_LOCATION_Settings
 *
 *
 * @deprecated
 */
class TF_LOCATION_Settings
{
    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     * @deprecated
     */
    public static function getSettings()
    {
        return Settings::getList();
    }

    /**
     * @param $key
     * @return mixed|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     * @deprecated
     */
    public static function get($key)
    {
        return Settings::get($key);
    }

    /**
     * @param $arFields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     * @deprecated
     */
    public static function SetSettings($arFields)
    {
        Settings::setList($arFields);
    }
}