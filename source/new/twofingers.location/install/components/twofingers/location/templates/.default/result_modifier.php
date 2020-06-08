<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 13.03.2019
 * Time: 11:26
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__ . '/template.php');
/** colors */
$arResult['PRIMARY_COLOR'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR'])
    ? '#ffffff'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR'];

$arResult['PRIMARY_COLOR_HOVER'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER'])
    ? '#333333'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER'];

$arResult['PRIMARY_BG'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG'])
    ? '#2b7de0'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG'];

$arResult['PRIMARY_BG_HOVER'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER'])
    ? '#468de4'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER'];

$arResult['SECONDARY_COLOR'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR'])
    ? '#337ab7'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR'];

$arResult['SECONDARY_COLOR_HOVER'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER'])
    ? '#039be5'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER'];

$arResult['SECONDARY_BG'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG'])
    ? '#f5f5f5'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG'];

$arResult['SECONDARY_BG_HOVER'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER'])
    ? '#f5f5f5'
    : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER'];


if ($GLOBALS['TF_LOCATION_TEMPLATE_LOADED'] == 'Y') return;

/** js callback */
$arResult['JS_CALLBACK'] = str_replace("'", "\'", $arResult['SETTINGS']['TF_LOCATION_CALLBACK']).'; ';
if(!empty($arParams['PARAMS']['ONCITYCHANGE']))
    $arResult['JS_CALLBACK'] .= $arParams['PARAMS']['ONCITYCHANGE'].'(); ';

if(!empty($arParams['PARAMS']['JS_CALLBACK']))
    $arResult['JS_CALLBACK'] .= $arParams['PARAMS']['JS_CALLBACK'].'(); ';

$arResult['JS_CALLBACK'] = str_replace(';;', ';', $arResult['JS_CALLBACK']);

$arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH'] = intval($arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH']);
if (!$arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH'])
    $arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH'] = 767;

/** js params */
$arResult['JS_PARAMS'] = [
    'path'          => $arResult['COMPONENT_PATH'],
    'request_uri'   => $_SERVER['REQUEST_URI'],
    'ajax_search'   => ($arResult['SETTINGS']['TF_LOCATION_LOAD_LOCATIONS'] == 'defaults')
        || ($arResult['SETTINGS']['TF_LOCATION_LOAD_LOCATIONS'] == 'cities'),
    'mobile_width'  => $arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH']
];

$arResult['JS_PARAMS'] = Json::encode($arResult['JS_PARAMS']);

/** define popup text */
if (strlen($arResult['CITY_ID'])){
    $arResult['CONFIRM_POPUP_TEXT'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_TEXT'])
        ? Loc::getMessage('TF_LOCATION_YOUR_CITY') : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_TEXT'];

    $arResult['CONFIRM_POPUP_TEXT'] = str_replace('#location#', $arResult['CITY_NAME'], $arResult['CONFIRM_POPUP_TEXT']);
} else {
    $arResult['CONFIRM_POPUP_TEXT'] = is_null($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT'])
        ? Loc::getMessage('TF_LOCATION_NO_CITY') : $arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT'];
}




