<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arResult['SETTINGS']['TF_LOCATION_JQUERY_INCLUDE'] != "N")
    $GLOBALS['APPLICATION']->AddHeadScript($templateFolder . '/js/jquery-3.3.1.min.js');

$GLOBALS['APPLICATION']->AddHeadScript($templateFolder . '/js/jquery.slimscroll.min.js');
$GLOBALS['APPLICATION']->AddHeadScript($templateFolder . '/js/jquery.mousewheel.min.js');

$jsCallback = str_replace("'", "\'", $arResult['SETTINGS']['TF_LOCATION_CALLBACK']).';';

if($arParams['ORDER_TEMPLATE'] == 'Y'):
	if(!empty($arParams['PARAMS']['ONCITYCHANGE']))
		$jsCallback .= $arParams['PARAMS']['ONCITYCHANGE'].'();';

	if(!empty($arParams['PARAMS']['JS_CALLBACK']))
		$jsCallback .= $arParams['PARAMS']['JS_CALLBACK'].'();';

	?>
	<a href="#tfLocationPopup"
       class="<?=$arResult['SETTINGS']['TF_LOCATION_ORDERLINK_CLASS']?> tf_location_link in_order"
       onclick="return tfLocationPopupOpen('<?=$arResult['COMPONENT_PATH']?>', '<?=$jsCallback?>');"
        ><span><?=$arResult['CITY_NAME']?></span></a>
	<input type="hidden" name="<?=$arParams['PARAMS']['INPUT_NAME']?>" class="tf_location_city_input" value="<?=$arResult['CITY_ID']?>">
    <input type="hidden" autocomplete="off" class="bx-ui-sls-route" style="padding: 0px; margin: 0px;" value="<?=$arResult['CITY_NAME']?>">
<? else: ?>
	<a href="#tfLocationPopup"
       class="<?=$arResult['SETTINGS']['TF_LOCATION_HEADLINK_CLASS']?> tf_location_link"
       onclick="return tfLocationPopupOpen('<?=$arResult['COMPONENT_PATH']?>', '<?=$jsCallback?>');"
    ><?
		if( strlen($arResult['SETTINGS']['TF_LOCATION_HEADLINK_TEXT']) > 0 )
			echo $arResult['SETTINGS']['TF_LOCATION_HEADLINK_TEXT'], ':';
		?> <span><?=$arResult['CITY_NAME']?></span>
	</a>
<?endif;

if( $arResult['CALL_LOCATION_POPUP'] == 'Y' ):?>
    <script>
        $(function()
        {
            tfLocationPopupOpen('<?=$arResult['COMPONENT_PATH']?>', '<?=$jsCallback?>');
        });
    </script>
<? endif;

if ($GLOBALS['TF_LOCATION_TEMPLATE_LOADED'] != 'Y'): ?>
	<div class="custom-popup-2014-overlay" style="display:none;"></div>
	<div class="custom-popup-2014" style="display:none; border-radius:<?=intval($arResult['SETTINGS']['TF_LOCATION_POPUP_RADIUS'])?>px">
        <div class="custom-popup-2014-content">
            <div class="popup-title"><?=GetMessage("TF_LOCATION_CHECK_CITY")?></div>
            <div class="popup-search-wrapper">
                <input type="text" autocomplete="off" name="search" class="field-text city-search"><a href="#" class="clear_field"></a>
            </div>
            <ul class="current-list"></ul>
            <div class="popup-city nice-scroll">
                <div class="inner"></div>
                <div class="shadow"></div>
            </div>
        </div>
        <div class="custom-popup-2014-close"></div>
    </div>
<?
    $GLOBALS['TF_LOCATION_TEMPLATE_LOADED'] = 'Y';

endif;