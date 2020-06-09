<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Json;



$frame1 = $this->createFrame()->begin();

if($arParams['ORDER_TEMPLATE'] == 'Y'):

    $this->setFrameMode(false);

    ?>
    <span class="twgl__link-container">
        <a href="#twgLocationPopup"
            data-location-id="<?=$arResult['CITY_ID']?>"
            data-order="true"
            class="<?=$arResult['SETTINGS']['TWG_LOCATION_ORDERLINK_CLASS']?> twgl__link twgl__link_order"
        ><?=$arResult['CITY_NAME']?></a>
        <input type="hidden" name="<?=$arParams['PARAMS']['INPUT_NAME']?>" class="twg_location_city_input" value="<?=$arResult['CITY_ID']?>">
        <input type="hidden" autocomplete="off" class="bx-ui-sls-route" style="padding: 0px; margin: 0px;" value="<?=$arResult['CITY_NAME']?>">
    </span>
<? else:

    $this->setFrameMode(true);

    ?>
    <span class="twgl__link-container">
        <? if(strlen($arResult['SETTINGS']['TWG_LOCATION_HEADLINK_TEXT']) > 0 )
            echo $arResult['SETTINGS']['TWG_LOCATION_HEADLINK_TEXT'], ': ';
        ?><a href="#twgLocationPopup"
           data-location-id="<?=$arResult['CITY_ID']?>"
           class="<?=$arResult['SETTINGS']['TWG_LOCATION_HEADLINK_CLASS']?> twgl__link"
        ><?=$arResult['CITY_NAME']?></a>
    </span>
<?endif;

$frame1->beginStub();

?><span class="twgl__link-container">
    <? if(strlen($arResult['SETTINGS']['TWG_LOCATION_HEADLINK_TEXT']) > 0 )
        echo $arResult['SETTINGS']['TWG_LOCATION_HEADLINK_TEXT'], ': ';
    ?><a href="#twgLocationPopup"
         class="<?=$arResult['SETTINGS']['TWG_LOCATION_HEADLINK_CLASS']?> twgl__link"><?=Loc::getMessage('TWG_LOCATION_CHOOSE')?></a>
</span><?php

$frame1->end();

if ($GLOBALS['TWG_LOCATION_TEMPLATE_LOADED'] == 'Y')
    return;

$GLOBALS['TWG_LOCATION_TEMPLATE_LOADED'] = 'Y';

$frame2 = $this->createFrame()->begin(''); // empty stub!!!

include_once 'style.php';

?><div class="twgl-popup-overlay" style="display:none;">
    <div class="twgl-popup">
        <?php $title = !is_null($arResult['SETTINGS']['TWG_LOCATION_LOCATION_POPUP_HEADER'])
            ? $arResult['SETTINGS']['TWG_LOCATION_LOCATION_POPUP_HEADER']
            : GetMessage("TWG_LOCATION_CHECK_CITY");

        if (strlen($title)): ?>
            <div class="twgl-popup__title-container">
                <div class="twgl-popup__title"><?=$title?></span></div>
            </div>
        <?php endif; ?>
        <div class="twgl-popup__search-wrapper">
            <input
                    type="text"
                    autocomplete="off"
                    name="search"
                    placeholder="<?=!is_null($arResult['SETTINGS']['TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER'])
                        ? $arResult['SETTINGS']['TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER']
                        : GetMessage("TWG_LOCATION_CHECK_CITY_PLACEHOLDER")?>"
                    class="twgl-popup__search-input">
            <a href="#" class="twgl-popup__clear-field">
                <span class="twgl-popup__close"></span>
            </a>
            <div class="twgl-popup__search-icon">
                <svg class="svg svg-search" width="17" height="17" viewBox="0 0 17 17" aria-hidden="true"><path class="cls-1" d="M16.709,16.719a1,1,0,0,1-1.412,0l-3.256-3.287A7.475,7.475,0,1,1,15,7.5a7.433,7.433,0,0,1-1.549,4.518l3.258,3.289A1,1,0,0,1,16.709,16.719ZM7.5,2A5.5,5.5,0,1,0,13,7.5,5.5,5.5,0,0,0,7.5,2Z"></path></svg>
            </div>
        </div>
        <div class="twgl-popup__lists-container">
            <div class="twgl-popup__container twgl-popup__defaults">
                <div class="twgl-popup__scroll-container">
                    <ul class="twgl-popup__list"></ul>
                </div>
            </div>
            <div class="twgl-popup__container twgl-popup__locations">
                <div class="twgl-popup__scroll-container">
                    <ul class="twgl-popup__list"></ul>
                </div>
                <div class="twgl-popup__nofound-mess"><?= $arResult['SETTINGS']['TWG_LOCATION_LOCATION_POPUP_NO_FOUND']?></div>
            </div>
        </div>
        <div class="twgl-popup__close-container"><div class="twgl-popup__close"></div></div>
    </div>
</div>
<div class="twgl-define-popup" style="display:none;"><div class="twgl-define-popup__text"><?=$arResult['CONFIRM_POPUP_TEXT']?></div>
    <div class="twgl-define-popup__buttons" style="border-radius: 0 0 <?=intval($arResult['SETTINGS']['TWG_LOCATION_CONFIRM_POPUP_RADIUS'])?>px <?=intval($arResult['SETTINGS']['TWG_LOCATION_CONFIRM_POPUP_RADIUS'])?>px">
        <?php if (strlen($arResult['CITY_ID'])): ?>
            <a href="#" class="twgl-define-popup__button twgl-define-popup__main twgl-define-popup__yes"><?=Loc::getMessage('TWG_LOCATION_YES')?></a>
            <a href="#" class="twgl-define-popup__button twgl-define-popup__second twgl-define-popup__list"><?=Loc::getMessage('TWG_LOCATION_LIST')?></a>
        <? else: ?>
            <a href="#" class="twgl-define-popup__button twgl-define-popup__main twgl-define-popup__list"><?=Loc::getMessage('TWG_LOCATION_LIST')?></a>
            <a href="#" class="twgl-define-popup__button twgl-define-popup__second twgl-define-popup__yes"><?=Loc::getMessage('TWG_LOCATION_CLOSE')?></a>
        <?php endif;?>
    </div>
    <div class="twgl-popup__close-container"><div class="twgl-popup__close"></div></div>
</div>
<script>

$(function()
{
    var Location = new TwGLocation(<?=$arResult['JS_PARAMS']?>, '<?=$arResult['JS_CALLBACK']?>');

    $('body').on('click', '.twgl__link', function () {
        Location.openLocationsPopup($(this));

        e.stopPropagation();
        e.preventDefault();

        return false;
    });

    <? if($arResult['CALL_CONFIRM_POPUP'] == 'Y'):?>
        Location.openConfirmPopup();
    <?php endif;

    if($arResult['CALL_LOCATION_POPUP'] == 'Y'):?>
        Location.openLocationsPopup();
    <?php endif;?>
});

</script>
<?php $frame2->end();