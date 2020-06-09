<?
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

$moduleName = "twgeo.location";
define("ADMIN_MODULE_NAME", $moduleName);
define("ADMIN_MODULE_ICON", "");

include($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/twgeo.location/lang/".LANGUAGE_ID."/install/index.php");

$APPLICATION->SetTitle(GetMessage('TITLE'));
?>