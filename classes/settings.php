<?
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use \TWGeo\Location\Settings;

/**
 * Class TWG_LOCATION_Settings
 *
 *
 * @deprecated
 */
class TWG_LOCATION_Settings
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