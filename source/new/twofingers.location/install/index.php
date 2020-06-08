<?php

use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main;
use TwoFingers\Location\Iblock\Content;
use TwoFingers\Location\Iblock\Domain;
use TwoFingers\Location\Location;

Loc::loadMessages(__FILE__);

global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang) - strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang . "/lang/", "/install/index.php"));

class twofingers_location extends CModule
{
    var $MODULE_ID = 'twofingers.location';
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;

    function twofingers_location()
    {
        $arModuleVersion = array();
        include(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = GetMessage('TF_LOCATION_INSTALL_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('TF_LOCATION_INSTALL_DESCRIPTION');
        $this->PARTNER_NAME = GetMessage("TF_LOCATION_PARTNER");
        $this->PARTNER_URI = GetMessage("TF_LOCATION_PARTNER_URI");
    }

    public function DoInstall()
    {
        RegisterModule($this->MODULE_ID);
        $this->InstallDB();
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/components/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/location/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/.default/components', true, true);
        self::includeClasses();
        Domain::build();
        Content::build();
        if (Location::getType() == Location::TYPE__INTERNAL) \TwoFingers\Location\Iblock\Location::build();
        $this->InstallEvents();
        LocalRedirect('/bitrix/admin/settings.php?lang=ru&mid=twofingers.location&mid_menu=1');
    }

    protected static function includeClasses()
    {
        include_once __DIR__ . '/../lib/location.php';
        include_once __DIR__ . '/../lib/location/sale.php';
        include_once __DIR__ . '/../lib/location/sale2.php';
        include_once __DIR__ . '/../lib/location/internal.php';
        include_once __DIR__ . '/../lib/helper/tools.php';
        include_once __DIR__ . '/../lib/iblock.php';
        include_once __DIR__ . '/../lib/iblock/content.php';
        include_once __DIR__ . '/../lib/iblock/domain.php';
        include_once __DIR__ . '/../lib/iblock/location.php';
    }

    public function UnInstallEvents()
    {
        parent::UnInstallEvents();
        $eventManager = Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'OnBeforeProlog', 'twofingers.location', '\TwoFingers\Location\Event', 'onBeforeProlog');
        $eventManager->unRegisterEventHandler('iblock', 'OnAfterIBlockElementAdd', 'twofingers.location', '\TwoFingers\Location\Event', 'onAfterIBlockElementUpdate');
        $eventManager->unRegisterEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'twofingers.location', '\TwoFingers\Location\Event', 'onAfterIBlockElementUpdate');
    }

    public function InstallEvents()
    {
        parent::InstallEvents();
        $eventManager = Main\EventManager::getInstance();
        $eventManager->registerEventHandler('main', 'OnBeforeProlog', 'twofingers.location', '\TwoFingers\Location\Event', 'onBeforeProlog');
        $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementAdd', 'twofingers.location', '\TwoFingers\Location\Event', 'onAfterIBlockElementUpdate');
        $eventManager->registerEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'twofingers.location', '\TwoFingers\Location\Event', 'onAfterIBlockElementUpdate');
    }

    public function InstallDB()
    {

    }

    public function DoUninstall()
    {
        DeleteDirFilesEx("/" . $this->MODULE_ID . "/");
        DeleteDirFilesEx('/bitrix/components/twofingers/location/');
        DeleteDirFilesEx('/bitrix/templates/.default/components/bitrix/sale.ajax.locations/tf_location/');
        DeleteDirFilesEx('/bitrix/templates/.default/components/bitrix/sale.location.selector.search/.default/');
        DeleteDirFilesEx('/bitrix/templates/.default/components/bitrix/sale.location.selector.steps/.default/');
        $this->UnInstallEvents();
        UnRegisterModule($this->MODULE_ID);
    }
}