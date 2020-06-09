<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 07.03.2019
 * Time: 13:28
 *
 *
 */

namespace TWGeo\Location;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Web\Json;

Loc::loadMessages(__FILE__);
/**
 * Class Settings
 *
 * @package TWGeo\Location
 *
 */
class Settings
{
    const MODULE_ID = 'twgeo.location';

    /** @TODO */
    public static function getNewMap()
    {
        return [
            'main' => [
                'tab'   => Loc::getMessage('TWG_LOCATION_SETTINGS_TAB'),
                'title' => Loc::getMessage('TWG_LOCATION_SETTINGS_TAB_TITLE'),
                'inputs' => [
                    'TWG_LOCATION_HEADLINK_TEXT'     => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_HEADLINK_TEXT_DEFAULT')],
                    'TWG_LOCATION_JQUERY_INCLUDE'    => ['type' => 'CHECKBOX', 'default' => 'N'],
                    'TWG_LOCATION_COOKIE_LIFETIME'   => ['type' => 'TEXT', 'default' => 7],
                    'TWG_LOCATION_MOBILE_WIDTH'      => ['type' => 'INT', 'default' => '767'],
                    'TWG_LOCATION_SHOW_VILLAGES'     => ['type' => 'CHECKBOX', 'default' => 'N', 'visible' => Location::TYPE__SALE_2],
                ]
            ],
            'location_popup' => [
                'tab'   => Loc::getMessage('TWG_LOCATION_DEFAULT_LOCATION'),
                'title' => Loc::getMessage('TWG_LOCATION_DEFAULT_LOCATION_DESCR'),
                'inputs' => [
                    'TWG_LOCATION_BEHAVOUR_HEADING' => ['type' => 'heading'],
                    'TWG_LOCATION_ONUNKNOWN'         => ['type' => 'CHECKBOX', 'default' => 'N'],
                    'TWG_LOCATION_LOAD_LOCATIONS'=> [
                        'type'      => 'LIST',
                        'default'   => 'all',
                        'options'   => [
                            'all'       => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_all'),
                            'cities'    => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_cities'),
                            'defaults'  => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_defaults'),
                        ]
                    ],
                    'TWG_LOCATION_RELOAD'                => ['type' => 'CHECKBOX', 'default' => 'N'],
                    'TWG_LOCATION_CALLBACK'              => ['type' => 'TEXT', 'default' => ''],

                    'TWG_LOCATION_CHOOSE_CITY_HEADING'   => ['type' => 'heading', 'visible' => [Location::TYPE__SALE, Location::TYPE__SALE_2]],
                    'TWG_LOCATION_CHOOSE_CITY'           => ['type' => 'default_cities'],

                    'TWG_LOCATION_VISUAL_HEADING'        => ['type' => 'heading'],
                    'TWG_LOCATION_HEADLINK_CLASS'        => ['type' => 'TEXT', 'default' => ''],
                    'TWG_LOCATION_POPUP_RADIUS'          => ['type' => 'INT', 'default' => '10'],
                    //'TWG_LOCATION_LOCATION_POPUP_PRELOADER'      => ['type' => 'FILE', 'default' => null],
                    'TWG_LOCATION_STRINGS_HEADING'       => ['type' => 'heading'],

                    'TWG_LOCATION_LOCATION_POPUP_HEADER'         => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_HEADER_DEFAULT')],
                    'TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER'    => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER_DEFAULT')],
                    'TWG_LOCATION_LOCATION_POPUP_NO_FOUND'       => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_NO_FOUND_DEFAULT')],
                ],
                'confirm_popup' => [
                    'tab'   => Loc::getMessage('TWG_LOCATION_CONFIRM_LOCATION'),
                    'title' => Loc::getMessage('TWG_LOCATION_CONFIRM_LOCATION_DESCR'),
                    'inputs' => [
                        'TWG_LOCATION_BEHAVOUR_HEADING' => ['type' => 'heading'],
                        'TWG_LOCATION_SHOW_CONFIRM_POPUP'=> [
                            'type' => 'LIST',
                            'default' => 'N',
                            'options' => [
                                'N' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_N'),
                                'Y' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_Y'),
                                'A' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_A'),
                                'U' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_U'),
                            ]
                        ],

                        'TWG_LOCATION_VISUAL_HEADING'        => ['type' => 'heading'],
                        'TWG_LOCATION_CONFIRM_POPUP_RADIUS'          => ['type' => 'INT', 'default' => 5],
                    ]
                ]
            ]
        ];
    }

    public static function getMap()
    {
        return [
            'TWG_LOCATION_FROM'              => ['type' => 'TEXT', 'default' => ''],
            'TWG_LOCATION_CALLBACK'          => ['type' => 'TEXT', 'default' => ''],
            'TWG_LOCATION_HEADLINK_CLASS'    => ['type' => 'TEXT', 'default' => ''],
            'TWG_LOCATION_ORDERLINK_CLASS'   => ['type' => 'TEXT', 'default' => ''],
            'TWG_LOCATION_POPUP_RADIUS'      => ['type' => 'INT', 'default' => '10'],
            'TWG_LOCATION_HEADLINK_TEXT'     => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_HEADLINK_TEXT_DEFAULT')],
            'TWG_LOCATION_DEFAULT_CITIES'    => ['type' => 'ARRAY', 'default' => []],
            'TWG_LOCATION_DEFAULT_CITY'      => ['type' => 'TEXT', 'default' => ''],
            'TWG_LOCATION_ONUNKNOWN'         => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_REDIRECT'=> [
                'type' => 'LIST',
                'default' => 'N',
                'options' => [
                    'N' => Loc::getMessage('TWG_LOCATION_REDIRECT_N'),
                    'A' => Loc::getMessage('TWG_LOCATION_REDIRECT_A'),
                    'C' => Loc::getMessage('TWG_LOCATION_REDIRECT_C'),
                ]
            ],
            'TWG_LOCATION_SHOW_CONFIRM_POPUP'=> [
                'type' => 'LIST',
                'default' => 'N',
                'options' => [
                    'N' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_N'),
                    'Y' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_Y'),
                    'A' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_A'),
                    'U' => Loc::getMessage('TWG_LOCATION_SHOW_CONFIRM_POPUP_U'),
                ]
            ],
           /* 'TWG_LOCATION_MAIN_SERVICE'=> [
                'type'      => 'LIST',
                'default'   => 'sxgeo',
                'options'   => [
                    'sxgeo'       => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_all'),
                    'cities'    => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_cities'),
                    'defaults'  => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_defaults'),
                ]
            ],*/
            'TWG_LOCATION_LOAD_LOCATIONS'=> [
                'type'      => 'LIST',
                'default'   => 'all',
                'options'   => [
                    'all'       => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_all'),
                    'cities'    => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_cities'),
                    'defaults'  => Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_defaults'),
                ]
            ],
            'TWG_LOCATION_CONFIRM_POPUP_TEXT'            => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_TEXT_DEFAULT')],
            'TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT'      => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT_DEFAULT')],
            'TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR'   => ['type' => 'TEXT', 'default' => '#ffffff'],
            'TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER'   => ['type' => 'TEXT', 'default' => '#333333'],
            'TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG'      => ['type' => 'TEXT', 'default' => '#2b7de0'],
            'TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER'=> ['type' => 'TEXT', 'default' => '#468de4'],
            'TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR'   => ['type' => 'TEXT', 'default' => '#337ab7'],
            'TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER'   => ['type' => 'TEXT', 'default' => '#039be5'],
            'TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG'      => ['type' => 'TEXT', 'default' => '#f5f5f5'],
            'TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER'=> ['type' => 'TEXT', 'default' => '#f5f5f5'],
            'TWG_LOCATION_MOBILE_WIDTH'                  => ['type' => 'INT', 'default' => '767', 'size' => 4],
            'TWG_LOCATION_DELIVERY'                      => ['type' => 'CHECKBOX', 'default' => 'Y'],
            'TWG_LOCATION_DELIVERY_ZIP'                  => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_TEMPLATE'                      => ['type' => 'CHECKBOX', 'default' => 'Y'],
            'TWG_LOCATION_JQUERY_INCLUDE'                => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_RELOAD'                        => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_SHOW_VILLAGES'                 => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_SXGEO_MEMORY'                  => ['type' => 'CHECKBOX', 'default' => 'N'],
            'TWG_LOCATION_LOCATION_POPUP_HEADER'         => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_HEADER_DEFAULT')],
            'TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER'    => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER_DEFAULT')],
            'TWG_LOCATION_LOCATION_POPUP_NO_FOUND'       => ['type' => 'TEXT', 'default' => Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_NO_FOUND_DEFAULT')],
            //'TWG_LOCATION_LOCATION_POPUP_PRELOADER'      => ['type' => 'FILE', 'default' => null],
            'TWG_LOCATION_CONFIRM_POPUP_RADIUS'          => ['type' => 'INT', 'default' => 5],
            'TWG_LOCATION_COOKIE_LIFETIME'               => ['type' => 'TEXT', 'default' => 7, 'size' => 4],
        ];
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function getList()
    {
        $settings   = array();
        $map        = self::getMap();

        foreach($map as $code => $config)
        {
            $value = Option::get(self::MODULE_ID, $code, null);

            if (is_null($value)) {
                $value = $config['default'];
            } else {
                if($config['type'] == 'ARRAY') {
                    try{
                        $value = Json::decode($value);
                    } catch (\Exception $e) {
                        $value = $config['default'];
                    }
                } elseif($config['type'] == 'CHECKBOX'
                    && ($config['default'] == 'N')
                    && ($value != 'Y'))
                {
                    $value = 'N';
                }
            }

            $settings[$code] = $value;
        }

        return $settings;
    }

    /**
     * @param $key
     * @return mixed|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function get($key)
    {
        $key = trim($key);
        if (!$key) return null;

        $settings = self::getList();
        if (isset($settings[$key]))
            return $settings[$key];

        return null;
    }

    /**
     * @param $fields
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function setList($fields)
    {
        $val    = null;
        $map    = self::getMap();

        foreach ($map as $code => $config)
        {
            if ($config['type'] == 'CHECKBOX' && !isset($fields[$code])) {
                $val = 'N';
            } elseif (isset($fields[$code])) {
                $val = $fields[$code];
            }

            if ($config['type'] == 'ARRAY')
                $val = Json::encode($fields[$code]);

            if ($config['type'] == 'INT')
                $val = intval($val);

            if (is_null($val))
                $val = $config['default'];

            Option::set(self::MODULE_ID, $code, $val);
        }
    }
}