<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use TwoFingers\Location\Settings,
    Bitrix\Main\Loader,
    \TwoFingers\Location\Storage;

if(!Loader::IncludeModule('twofingers.location'))
{
    ShowError('Module twofingers.location not installed');
    return;
}

$arResult['CALL_CONFIRM_POPUP'] = 'N';
$arResult['CALL_LOCATION_POPUP']= 'N';

$settings = Settings::getList();

// getting new data
if (Storage::getNeedCheck() == 'Y')
{
    if (($settings['TF_LOCATION_SHOW_CONFIRM_POPUP'] == 'Y')
        || (($settings['TF_LOCATION_SHOW_CONFIRM_POPUP'] == 'U') && (Storage::getConfirmPopupClosedByUser() != 'Y')))
    {
        $arResult['CALL_CONFIRM_POPUP'] = 'Y';
    }
} elseif (($settings['TF_LOCATION_SHOW_CONFIRM_POPUP'] == 'A')
    && (Storage::getConfirmPopupClosedByUser() != 'Y'))
{
    $arResult['CALL_CONFIRM_POPUP'] = 'Y';
}

// try to get info
if (Storage::isEmpty())
{
    $arResult['CITY_NAME']  = GetMessage("TF_LOCATION_CHOOSE");
    $arResult['CITY_ID']    = false;

    if (($settings['TF_LOCATION_ONUNKNOWN'] == 'Y') && ($arResult['CALL_CONFIRM_POPUP'] == 'N'))
        $arResult['CALL_LOCATION_POPUP'] = 'Y';

} else {
    $arResult['CITY_ID']    = Storage::getLocationId();
    $arResult['CITY_NAME']  = Storage::getLocationName();
}

$arResult['SETTINGS']       = $settings;
$arResult['COMPONENT_PATH'] = $componentPath;
$arResult['AJAX_SEARCH']    = (Settings::get('TF_LOCATION_LOAD_LOCATIONS') == 'cities')
    || (Settings::get('TF_LOCATION_LOAD_LOCATIONS') == 'defaults');

$this->IncludeComponentTemplate();

return $arResult;
