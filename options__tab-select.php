<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

$tab->BeginNextTab();

use Bitrix\Main\Localization\Loc;
use TWGeo\Location\Helper\Options;
use TWGeo\Location\Location;
?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_BEHAVOUR_HEADING')?></td>
</tr>
<?php

Options::showCheckboxRow('TWG_LOCATION_ONUNKNOWN', $settings);

if(Location::getType() == Location::TYPE__SALE_2)
    Options::showCheckboxRow('TWG_LOCATION_SHOW_VILLAGES', $settings);

?>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <label for="TWG_LOCATION_LOAD_LOCATIONS"><?=Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <select name="TWG_LOCATION_LOAD_LOCATIONS" id="TWG_LOCATION_LOAD_LOCATIONS">
            <option value="all"<?if ($settings['TWG_LOCATION_LOAD_LOCATIONS'] == 'all'):?> selected<?endif?>><?= Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_all')?></option>
            <? if(Location::getType() == Location::TYPE__SALE_2):?>
                <option value="cities"<?if ($settings['TWG_LOCATION_LOAD_LOCATIONS'] == 'cities'):?> selected<?endif?>><?=Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_cities')?></option>
            <? endif; ?>
            <option value="defaults"<?if ($settings['TWG_LOCATION_LOAD_LOCATIONS'] == 'defaults'):?> selected<?endif?>><?=Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_defaults')?></option>
        </select>
        <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_LOAD_LOCATIONS_HELP')?></div>
    </td>
</tr>
<?
Options::showCheckboxRow('TWG_LOCATION_RELOAD', $settings);
Options::showTextRow('TWG_LOCATION_CALLBACK', $settings);
?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_CHOOSE_CITY_HEADING')?></td>
</tr>

<tr class="">
    <td width="40%" class="adm-detail-content-cell-l" valign="top">
        <?=Loc::getMessage('TWG_LOCATION_CHOOSE_CITY')?>:
    </td>
    <td width="60%" class="adm-detail-content-cell-r" valign="top">
        <ul class="twgl__cities">
            <?
            // include CMainPage
            require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/mainpage.php");
            // get site_id by host
            $obMainPage = new \CMainPage();
            $realSiteId = $obMainPage->GetSiteByHost();
            if(!$realSiteId)
                $realSiteId = "s1";

            $defaultCities = Location::getDefaultList(SITE_ID, $realSiteId);

            if (count($defaultCities)):

                foreach ($defaultCities as $defaultCity):

                    $parents = '';
                    if (isset($defaultCity['REGION_NAME']))
                        $parents .= ', ' . $defaultCity['REGION_NAME'];

                    if (isset($defaultCity['COUNTRY_NAME']))
                        $parents .= ', ' . $defaultCity['COUNTRY_NAME'];

                    ?><li data-id="<?=$defaultCity['ID']?>"><?=$defaultCity['NAME'];?><span style="color: #999"><?=$parents?></span><?
                    if (Location::getType() == Location::TYPE__SALE):
                        ?> <input type="hidden" value="<?=$defaultCity['ID']?>" name="TWG_LOCATION_DEFAULT_CITIES[]"><i></i><?php
                    endif;

                    ?></li>
                <?php endforeach;

            else: ?>
                <li class="empty_location_el"><?=Loc::getMessage('TWG_LOCATION_EMPTY_LIST');?></li>
            <? endif;?>
    </td>
</tr>
<?if (Location::getType() == Location::TYPE__SALE):?>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TWG_LOCATION_ADD_CITY');?>:
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?
            $arLocationParams = array(
                "AJAX_CALL"             => "N",
                "COUNTRY_INPUT_NAME"    => "COUNTRY_tmp",
                "REGION_INPUT_NAME"     => "REGION_tmp",
                "CITY_INPUT_NAME"       => "tmp",
                "INPUT_NAME"            => 'tmp',
                "CITY_OUT_LOCATION"     => "Y",
                "LOCATION_VALUE"        => "",
                "ONCITYCHANGE"          => "setCity($('#tmp').val())",
            );
            $APPLICATION->IncludeComponent(
                "bitrix:sale.ajax.locations",
                ".default",
                $arLocationParams,
                null,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_ADD_CITY_HELP')?></div>
            <script>
                function setCity(cityID) {
                    var ArLocationName = $('#tmp_val_div_' + cityID + '_NAME').text().split(','),
                        cityNAME = ArLocationName[0];

                    $('.empty_location_el').remove();
                    $('.twgl__cities').append('<li data-id="'+cityID+'">'+cityNAME+'<input type="hidden" value="'+cityID+'" name="TWG_LOCATION_DEFAULT_CITIES[]"><i></i></li>');
                    $('#LOCATION_tmp select').not('#COUNTRY_tmptmp').remove();
                    $('#COUNTRY_tmptmp option').first().attr('selected', 'selected');
                }

                $(function() {
                    $(document).delegate('.twgl__cities li i', 'click', function() {
                        $(this).parent().remove();
                    });
                    /* $(document).on('click', '.select_place', function(){
                     var locationID = $('input[name="tmp"]').val();
                     if(locationID != ""){
                     var LocationObj = $('.bx-ui-combobox-variant-active');
                     count = LocationObj.length;
                     var LocationSelectedElement = LocationObj[count-1];
                     var LocationName = LocationSelectedElement.textContent;
                     $('.empty_location_el').remove();
                     $('.twgl__cities').append('<li data-id="'+locationID+'">'+LocationName+'<input type="hidden" value="'+locationID+'" name="TWG_LOCATION_DEFAULT_CITIES[]"><i></i></li>');
                     $('#LOCATION_tmp select').not('#COUNTRY_tmptmp').remove();
                     $('#COUNTRY_tmptmp option').first().attr('selected', 'selected');
                     }
                     });*/
                });
            </script>
        </td>
    </tr>
<? elseif(Location::getType() == Location::TYPE__SALE_2): ?>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITIES_S2')?>
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_ADD_CITY_HELP')?></div>

        </td>

    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITY')?>:
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <? $APPLICATION->IncludeComponent(
                "bitrix:sale.location.selector.search",
                ".default",
                array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "ID" => $settings['TWG_LOCATION_DEFAULT_CITY'],
                    "CODE" => '',
                    "INPUT_NAME" => "LOCATION",
                    "PROVIDE_LINK_BY" => "id",
                    "FILTER_BY_SITE" => "N",
                    "SHOW_DEFAULT_LOCATIONS" => "N",
                    "FILTER_SITE_ID" => "current",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "JS_CONTROL_GLOBAL_ID" => "",
                    "JS_CALLBACK" => "setSale2DefaultCity",
                    "SUPPRESS_ERRORS" => "N",
                    "INITIALIZE_BY_GLOBAL_EVENT" => "",
                    "COMPOSITE_FRAME_MODE" => "A",
                    "COMPOSITE_FRAME_TYPE" => "AUTO"
                ),
                false
            );
            ?>
            <script>
                function setSale2DefaultCity(itemId, selector) {
                    $('#TWG_LOCATION_DEFAULT_CITY').val(itemId);
                }
            </script>
            <input type="hidden" id="TWG_LOCATION_DEFAULT_CITY" name="TWG_LOCATION_DEFAULT_CITY" value="">
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITY_HELP')?><br><?=Loc::getMessage('TWG_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
<?php else: ?>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top"></td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITIES_INTERNAL')?>
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITY')?>:
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?
            $defaultLocation = Location\Internal::getDefault();
            if (isset($defaultLocation['NAME']))
                echo $defaultLocation['NAME'];
            else
                echo Loc::getMessage('TWG_LOCATION_DEFAULT_CITY_NONE');
            ?>
            <?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITY_INTERNAL')?>
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_DEFAULT_CITY_HELP')?><br><?=Loc::getMessage('TWG_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
<?php endif; ?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_VISUAL_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_HEADLINK_CLASS"><?=Loc::getMessage('TWG_LOCATION_HEADLINK_CLASS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_HEADLINK_CLASS" id="TWG_LOCATION_HEADLINK_CLASS" value="<?=$settings['TWG_LOCATION_HEADLINK_CLASS']?>">
        <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_HEADLINK_CLASS_HELP')?></div>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
        <label for="TWG_LOCATION_POPUP_RADIUS"><?=Loc::getMessage('TWG_LOCATION_POPUP_RADIUS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="2" type="text" name="TWG_LOCATION_POPUP_RADIUS" id="TWG_LOCATION_POPUP_RADIUS" value="<?=$settings['TWG_LOCATION_POPUP_RADIUS']?>"> px.
        <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_POPUP_RADIUS_HELP')?></div>
    </td>
</tr>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_STRINGS_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_LOCATION_POPUP_HEADER"><?=Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_HEADER') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_LOCATION_POPUP_HEADER" id="TWG_LOCATION_LOCATION_POPUP_HEADER" value="<?=$settings['TWG_LOCATION_LOCATION_POPUP_HEADER']?>">
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER"><?=Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER" id="TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER" value="<?=$settings['TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER']?>">
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_LOCATION_POPUP_NO_FOUND"><?=Loc::getMessage('TWG_LOCATION_LOCATION_POPUP_NO_FOUND') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_LOCATION_POPUP_NO_FOUND" id="TWG_LOCATION_LOCATION_POPUP_NO_FOUND" value="<?=$settings['TWG_LOCATION_LOCATION_POPUP_NO_FOUND']?>">
    </td>
</tr>
<?	$tab->EndTab();