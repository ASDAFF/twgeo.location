<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 13.03.2019
 * Time: 13:50
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

use TWGeo\Location\Iblock\Location;

$MESS['TWGL_IBLOCK_LOCATION_NAME']        = 'Местоположения';
$MESS['TWGL_IBLOCK_LOCATION_DESCRIPTION'] = 'Содержит доступные местоположения';
$MESS['TWGL_IBLOCK_LOCATION_RUSSIA']     = 'Россия';

$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_FEATURED]             = 'Избранное';
$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_FEATURED . '_HINT']   = 'Выводить в избранных местоположениях';
$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_FEATURED . '_YES']    = 'Да';
$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_DEFAULT]              = 'По-умолчанию';
$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_DEFAULT . '_HINT']    = 'Выводить, если не удалось определить местоположение';
$MESS['TWGL_IBLOCK_PROP_' . Location::PROPERTY_DEFAULT . '_YES']     = 'Да';