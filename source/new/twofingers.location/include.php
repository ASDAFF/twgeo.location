<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;

if (!function_exists('getModuleVersion')) {
    function getModuleVersion($module)
    {
        $module = preg_replace('/[^a-zA-Z0-9_.]+/i', '', trim($module));
        if ($module == '') return false;
        if (!ModuleManager::isModuleInstalled($module)) return false;
        if ($module == 'main') {
            if (!defined('SM_VERSION')) include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/version.php');
            return SM_VERSION;
        }
        $pathModule = getLocalPath('modules/' . $module . '/install/version.php');
        if ($pathModule === false) return false;
        $arModuleVersion = array();
        include($_SERVER['DOCUMENT_ROOT'] . $pathModule);
        return array_key_exists('VERSION', $arModuleVersion) ? $arModuleVersion['VERSION'] : false;
    }
}
$eventManager = EventManager::getInstance();
if (CheckVersion(getModuleVersion('sale'), '16.0.26')) {
    $eventManager->addEventHandler('sale', 'OnSaleComponentOrderResultPrepared', ['\TwoFingers\Location\Event', 'setZip']);
    $eventManager->addEventHandler('sale', 'OnSaleComponentOrderProperties', ['\TwoFingers\Location\Event', 'setSaleLocation']);
} else {
    $eventManager->addEventHandler('sale', 'OnSaleComponentOrderOneStepOrderProps', ['\TwoFingers\Location\Event', 'setSaleLocationOld']);
}
CModule::AddAutoloadClasses('twofingers.location', array('TF_LOCATION_Settings' => 'classes/settings.php', 'TF_LOCATION_Helpers' => 'classes/helpers.php', 'TF_LOCATION_Location' => 'classes/location.php', 'TF_LOCATION_SaleLocation' => 'classes/salelocation.php',));
if (!empty($_SESSION['TF_LOCATION_SELECTED_CITY']) && empty($_SESSION['TF_LOCATION']['city_id'])) $_SESSION['TF_LOCATION']['city_id'] = $_SESSION['TF_LOCATION_SELECTED_CITY'];
if (!empty($_SESSION['TF_LOCATION_SELECTED_CITY_NAME']) && empty($_SESSION['TF_LOCATION']['city_name'])) $_SESSION['TF_LOCATION']['city_name'] = $_SESSION['TF_LOCATION_SELECTED_CITY_NAME'];
unset($_SESSION['TF_LOCATION_SELECTED_CITY_NAME']);
unset($_SESSION['TF_LOCATION_SELECTED_CITY']);