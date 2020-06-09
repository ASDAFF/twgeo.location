<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use TWGeo\Location\Settings,
    Bitrix\Main\Loader,
    \TWGeo\Location\Storage;

if(!Loader::IncludeModule('twgeo.location'))
{
    ShowError('Module twgeo.location not installed');
    return;
}

$arResult['CALL_CONFIRM_POPUP'] = 'N';
$arResult['CALL_LOCATION_POPUP']= 'N';

$settings = Settings::getList();

// getting new data
if (Storage::getNeedCheck() == 'Y')
{
    if (($settings['TWG_LOCATION_SHOW_CONFIRM_POPUP'] == 'Y')
        || (($settings['TWG_LOCATION_SHOW_CONFIRM_POPUP'] == 'U') && (Storage::getConfirmPopupClosedByUser() != 'Y')))
    {
        $arResult['CALL_CONFIRM_POPUP'] = 'Y';
    }
} elseif (($settings['TWG_LOCATION_SHOW_CONFIRM_POPUP'] == 'A')
    && (Storage::getConfirmPopupClosedByUser() != 'Y'))
{
    $arResult['CALL_CONFIRM_POPUP'] = 'Y';
}

// try to get info
if (Storage::isEmpty())
{
    $arResult['CITY_NAME']  = GetMessage("TWG_LOCATION_CHOOSE");
    $arResult['CITY_ID']    = false;

    if (($settings['TWG_LOCATION_ONUNKNOWN'] == 'Y') && ($arResult['CALL_CONFIRM_POPUP'] == 'N'))
        $arResult['CALL_LOCATION_POPUP'] = 'Y';

} else {
    $arResult['CITY_ID']    = Storage::getLocationId();
    $arResult['CITY_NAME']  = Storage::getLocationName();
}

$arResult['SETTINGS']       = $settings;
$arResult['COMPONENT_PATH'] = $componentPath;
$arResult['AJAX_SEARCH']    = (Settings::get('TWG_LOCATION_LOAD_LOCATIONS') == 'cities')
    || (Settings::get('TWG_LOCATION_LOAD_LOCATIONS') == 'defaults');

$this->IncludeComponentTemplate();

return $arResult;
