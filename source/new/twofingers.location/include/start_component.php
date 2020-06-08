<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init();

use \Bitrix\Main\Config\Option;

if($APPLICATION->GetCurDir() != '/bitrix/admin/'){

	if( !empty($arParams['CITY_INPUT_NAME']) )
		$arParams['INPUT_NAME'] = $arParams['CITY_INPUT_NAME'];

	$template = Option::get('twofingers.location', 'sale-order-template', '.default');

	$APPLICATION->IncludeComponent("twofingers:location", $template, array('ORDER_TEMPLATE'=>'Y', 'PARAMS'=>$arParams));

} else {

	// include original template for backoffice
	$componentName          = str_replace('bitrix:', '', $this->__component->__name);
	$originalTemplateDir    = "/bitrix/components/bitrix/$componentName/templates/.default/";
	$originalTemplateDirAbs = $_SERVER['DOCUMENT_ROOT'] . $originalTemplateDir;

    $asset = \Bitrix\Main\Page\Asset::getInstance();
    $asset->addJs($originalTemplateDir . 'script.js');
    $APPLICATION->SetAdditionalCSS($originalTemplateDir . 'style.css');

	foreach(['result_modifier.php', 'template.php', 'component_epilog.php'] as $fileName )
	{
		$originalTemplateFileAbs = $originalTemplateDirAbs . $fileName;

		if(is_file($originalTemplateFileAbs))
			require $originalTemplateFileAbs;
	}
}
