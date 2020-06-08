<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 13.03.2019
 * Time: 13:50
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

use TwoFingers\Location\Iblock\Domain;

$MESS['TFL_IBLOCK_DOMAIN_NAME']                     = 'Домены';
$MESS['TFL_IBLOCK_DOMAIN_DESCRIPTION']              = 'Содержит домены, на которые может быть выполнено атвоматическое перенаправление';
$MESS['TFL_IBLOCK_PROP_' . Domain::PROPERTY_DOMAIN] = 'Домен';
$MESS['TFL_IBLOCK_PROP_' . Domain::PROPERTY_DOMAIN .'_HINT']         = 'Укажите полное название домена, с http или https, например, https://yandex.ru';