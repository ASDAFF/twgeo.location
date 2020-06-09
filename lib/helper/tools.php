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

namespace TWGeo\Location\Helper;

use Bitrix\Main\SiteTable;

/**
 * Class Tools
 *
 * @package TWGeo\Location\Helper
 *
 */
class Tools
{
    /**
     * @return bool|mixed
     * @throws \Bitrix\Main\SystemException
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
     */
    public static function translit($name, $langId = LANGUAGE_ID)
    {
        return \CUtil::translit($name, $langId, ['replace_space' => '-', 'replace_other' => '-']);
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getSitesIds()
    {
        $query = [
            'select'    => ['LID'],
            'order'     => ['SORT' => 'ASC']
        ];

        $sites  = SiteTable::getList($query);
        $result = [];
        while ($site = $sites->fetch())
            $result[] = $site['LID'];

        return $result;
    }
}