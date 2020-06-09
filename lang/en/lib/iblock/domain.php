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

use TWGeo\Location\Iblock\Domain;

$MESS['TWGL_IBLOCK_DOMAIN_NAME']                     = 'Домены';
$MESS['TWGL_IBLOCK_DOMAIN_DESCRIPTION']              = 'Содержит домены, на которые может быть выполнено атвоматическое перенаправление';
$MESS['TWGL_IBLOCK_PROP_' . Domain::PROPERTY_DOMAIN] = 'Домен';
$MESS['TWGL_IBLOCK_PROP_' . Domain::PROPERTY_DOMAIN .'_HINT']         = 'Укажите полное название домена, с http или https, например, https://yandex.ru';