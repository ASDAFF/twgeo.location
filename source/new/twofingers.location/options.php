<?

use TwoFingers\Location\Location,
    TwoFingers\Location\Settings,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    \Bitrix\Main\SystemException,
    Bitrix\Main\Application,
    \TwoFingers\Location\Helper\Options;
use TwoFingers\Location\Service\SxGeo;

$module_id = "twofingers.location";

if (!Loader::includeModule('iblock'))
    throw new SystemException('module iblock not found');

if (!Loader::includeModule($module_id))
    throw new SystemException('module ' . $module_id . ' not found');

Loc::loadMessages(__FILE__);

$request = Application::getInstance()->getContext()->getRequest();

if ($request->get('TF_LOCATION_UPDATE_SX'))
{
    try{
        $message = [
            'TYPE'      => 'OK',
            "MESSAGE"   => SxGeo::run()
        ];
    } catch (\Exception $e) {
        $message = [
            'TYPE' => 'ERROR',
            "MESSAGE"   => $e->getMessage()
        ];
    }

    \CAdminMessage::ShowMessage($message);
}

if ($request->getPost('TF_LOCATION_SAVE_SETTINGS'))
{
    Settings::SetList($request->toArray());

    if ($request->getPost('TF_LOCATION_TEMPLATE') == 'Y') {
        CopyDirFiles(
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/".$module_id."/install/location/",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/templates/.default/components",
            true, true
        );
    } else {
        DeleteDirFilesEx("/bitrix/templates/.default/components/bitrix/sale.ajax.locations/");
        DeleteDirFilesEx("/bitrix/templates/.default/components/bitrix/sale.location.selector.search/");
        DeleteDirFilesEx("/bitrix/templates/.default/components/bitrix/sale.location.selector.steps/");
    }
}

CJSCore::Init(array("jquery"));
$settings   = Settings::getList();
//$settingsMap= Settings::getMap();
//$MOD_RIGHT  = $APPLICATION->GetGroupRight($module_id);

//if($MOD_RIGHT>="R" && true):

$aTabs = array(
    array(
        'TAB'   => Loc::getMessage('TF_LOCATION_SETTINGS_TAB'),
        'DIV'   =>'main',
        'TITLE' => Loc::getMessage('TF_LOCATION_SETTINGS_TAB_TITLE'),
    ),
    [
        'TAB'   => Loc::getMessage('TF_LOCATION_DEFAULT_LOCATION'),
        'DIV'   => 'location_popup',
        'TITLE' => Loc::getMessage('TF_LOCATION_DEFAULT_LOCATION_DESCR'),
    ],
    [
        'TAB'   => Loc::getMessage('TF_LOCATION_CONFIRM_LOCATION'),
        'DIV'   => 'confirm_popup',
        'TITLE' => Loc::getMessage('TF_LOCATION_CONFIRM_LOCATION_DESCR'),
    ]
);

if (Location::getType() != Location::TYPE__INTERNAL)
    $aTabs[] = [
        'TAB'   => Loc::getMessage('TF_LOCATION_SALE_SECTIONS'),
        'DIV'   => 'sale_popup',
        'TITLE' => Loc::getMessage('TF_LOCATION_SALE_SECTIONSDESCR'),
    ];

$tab = new \CAdminTabControl('TwoFingers_Settings_tab', $aTabs);
$tab->Begin();
?>

    <style>
        .tfl__cities {
            list-style: none outside none;
            margin: 0;
            padding: 0;
        }
        .tfl__cities li {
            margin-bottom: 3px;
        }
        .tfl__cities li i {
            background: url("/bitrix/panel/main/images/popup_menu_sprite_2.png") no-repeat scroll -8px -787px rgba(0, 0, 0, 0);
            cursor: pointer;
            display: inline-block;
            height: 15px;
            margin-bottom: -2px;
            margin-left: 5px;
            position: relative;
            width: 15px;
        }
        #LOCATION_tmp > select {
            display: block;
            margin-bottom: 5px;
        }
        .bx-ui-slst-pool .bx-ui-slst-input-block:nth-child(4){
            display: none;
        }
        .tfl-help{
            color: #999;
            font-size: 0.85em;
            margin-top: 0.3em
        }

        .tfl-help ul{
            margin-top: 0.3em;
            margin-bottom: 0.6em;
        }

        .tfl-options .adm-detail-content-cell-l{
            vertical-align: top;
        }

        .tfl-options .adm-detail-content-cell-l.adm-detail-content-text{
            padding-top: 0.8em
        }
    </style>
    <form method="post" class="tfl-options">
        <?php

        require __DIR__ . '/options__tab-main.php';
        require __DIR__ . '/options__tab-select.php';
        require __DIR__ . '/options__tab-confirm.php';

        if (Location::getType() != Location::TYPE__INTERNAL)
            require __DIR__ . '/options__tab-sale.php';

        $tab->Buttons();?>
        <input type="submit" name="TF_LOCATION_SAVE_SETTINGS" class="adm-btn-save"  value="<?=GetMessage('TF_LOCATION_SAVE') ?>" title="<?=GetMessage('TF_LOCATION_SAVE_TITLE') ?>" />
        <input type="button" onclick="window.document.location = '?lang=<?=LANGUAGE_ID ?>'" value="<?=GetMessage('TF_LOCATION_CANCEL') ?>" title="<?=GetMessage('TF_LOCATION_CANCEL_TITLE') ?>" />
    </form>
<?$tab->End();?>
<?//endif;?>