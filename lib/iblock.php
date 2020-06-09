<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 13.03.2019
 * Time: 12:46
 *
 *
 */

namespace TWGeo\Location;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use TWGeo\Location\Helper\Tools;

Loc::loadMessages(__FILE__);

/**
 * Class Element
 *
 * @package TWGeo\Location
 *
 */
class Iblock
{
    const TYPE = 'twg_location';

    /**
     * @return array
     *
     */
    public static function getType()
    {
        $filter = ['ID' => self::TYPE];

        return \CIBlockType::GetList([], $filter)->Fetch();
    }

    /**
     * @return bool
     * @throws \Bitrix\Main\LoaderException
     *
     */
    public static function createType()
    {
        if (!Loader::includeModule('iblock')) return false;

        $element = self::getType();
        if ($element) return true;

        $fields = [
            'ID'        => self::TYPE,
            'SECTIONS'  => 'Y',
            'IN_RSS'    => 'N',
            'SORT'      => 1000,
            'LANG' => [
                'en' => [
                    'NAME'          => 'Locations',
                    'SECTION_NAME'  => 'Sections',
                    'ELEMENT_NAME'  => 'Location'
                ],
                'ru' => [
                    'NAME'          => Loc::getMessage('TWGL_IBLOCK_TYPE_NAME'),
                    'SECTION_NAME'  => Loc::getMessage('TWGL_IBLOCK_TYPE_ELEMENT_NAME'),
                    'ELEMENT_NAME'  => Loc::getMessage('TWGL_IBLOCK_TYPE_SECTION_NAME')
                ]
            ]
        ];

        return (new \CIBlockType)->Add($fields);
    }

    /**
     * @param        $code
     * @param string $name
     * @param string $description
     * @return mixed
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function create($code, $name = '', $description = '')
    {
        $name = trim($name);
        if (!strlen($name))
            $name = Loc::getMessage('TWGL_IBLOCK_' . $code . '_NAME');

        $description = trim($description);
        if (!strlen($description))
            $description = Loc::getMessage('TWGL_IBLOCK_' . $code . '_DESCRIPTION');

        $data = [
            'ACTIVE'            => 'Y',
            'NAME'              => $name,
            'CODE'              => $code,
            'IBLOCK_TYPE_ID'    => self::TYPE,
            'SITE_ID'           => Tools::getSitesIds(),
            'SORT'              => 50,
            'DESCRIPTION'       => $description,
            "GROUP_ID"          => ["2"=>"R"]
        ];

        return (new \CIBlock)->Add($data);
    }

    /**
     * @return int
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function getId()
    {
        return intval(Option::get('twgeo.location', static::OPTION_IBLOCK_ID));
    }

    /**
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     *
     */
    public static function getIblock()
    {
        $iblockId = static::getId();
        if (!$iblockId || !Loader::includeModule('iblock'))
            return null;

        return \CIBlock::GetByID($iblockId)->Fetch();
    }

    /**
     * @param $code
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function getPropertyByCode($code)
    {
        $iblockId = static::getId();
        if (!$iblockId) return null;

        $filter = [
            'CODE'      => $code,
            'IBLOCK_ID' => static::getId()
        ];

        return \CIBlockProperty::GetList([], $filter)->Fetch();
    }

    /**
     * @param     $code
     * @param int $sort
     * @return bool
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    protected static function createCheckBoxProperty($code, $sort = 100)
    {
        $code = trim($code);
        if (!strlen($code))
            throw new ArgumentNullException('code');

        $property = self::getPropertyByCode($code);
        if ($property) return true;

        $iblockId = self::getId();
        if (!$iblockId) return false;

        $arFields = Array(
            "NAME"          => Loc::getMessage('TWGL_IBLOCK_PROP_' . $code),
            "HINT"          => Loc::getMessage('TWGL_IBLOCK_PROP_' . $code .'_HINT'),
            "ACTIVE"        => "Y",
            "SORT"          => $sort,
            "CODE"          => $code,
            "PROPERTY_TYPE" => "L",
            "IBLOCK_ID"     => $iblockId,
            'LIST_TYPE'     => 'C',
            'VALUES'        => [
                [
                    'VALUE' => Loc::getMessage('TWGL_IBLOCK_PROP_' . $code . '_YES'),
                    'DEF'   => 'N',
                    'SORT'  => 100,
                    'XML_ID'=> 'Y'
                ]
            ]
        );

        return (new \CIBlockProperty)->Add($arFields);
    }

    /**
     * @param        $code
     * @param int    $sort
     * @param string $required
     * @return bool
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    protected static function createStringProperty($code, $sort = 100, $required = 'N')
    {
        $code = trim($code);
        if (!strlen($code))
            throw new ArgumentNullException('code');

        $property = self::getPropertyByCode($code);
        if ($property) return true;

        $iblockId = self::getId();
        if (!$iblockId) return false;

        $arFields = Array(
            "NAME"          => Loc::getMessage('TWGL_IBLOCK_PROP_' . $code),
            "HINT"          => Loc::getMessage('TWGL_IBLOCK_PROP_' . $code . '_HINT'),
            "ACTIVE"        => "Y",
            "SORT"          => $sort,
            "CODE"          => $code,
            "PROPERTY_TYPE" => "S",
            "IBLOCK_ID"     => $iblockId,
            'IS_REQUIRED'   => $required
        );

        return (new \CIBlockProperty)->Add($arFields);
    }
}