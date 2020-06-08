<?php

$tab->BeginNextTab();

use Bitrix\Main\Localization\Loc;
use TwoFingers\Location\Helper\Options;
use TwoFingers\Location\Location;
?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_BEHAVOUR_HEADING')?></td>
</tr>
<?php

Options::showCheckboxRow('TF_LOCATION_ONUNKNOWN', $settings);

if(Location::getType() == Location::TYPE__SALE_2)
    Options::showCheckboxRow('TF_LOCATION_SHOW_VILLAGES', $settings);

?>
<tr>
    <td width="40%" class="adm-detail-content-cell-l">
        <label for="TF_LOCATION_LOAD_LOCATIONS"><?=Loc::getMessage('TF_LOCATION_LOAD_LOCATIONS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <select name="TF_LOCATION_LOAD_LOCATIONS" id="TF_LOCATION_LOAD_LOCATIONS">
            <option value="all"<?if ($settings['TF_LOCATION_LOAD_LOCATIONS'] == 'all'):?> selected<?endif?>><?= Loc::getMessage('TF_LOCATION_LOAD_LOCATIONS_all')?></option>
            <? if(Location::getType() == Location::TYPE__SALE_2):?>
                <option value="cities"<?if ($settings['TF_LOCATION_LOAD_LOCATIONS'] == 'cities'):?> selected<?endif?>><?=Loc::getMessage('TF_LOCATION_LOAD_LOCATIONS_cities')?></option>
            <? endif; ?>
            <option value="defaults"<?if ($settings['TF_LOCATION_LOAD_LOCATIONS'] == 'defaults'):?> selected<?endif?>><?=Loc::getMessage('TF_LOCATION_LOAD_LOCATIONS_defaults')?></option>
        </select>
        <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_LOAD_LOCATIONS_HELP')?></div>
    </td>
</tr>
<?
Options::showCheckboxRow('TF_LOCATION_RELOAD', $settings);
Options::showTextRow('TF_LOCATION_CALLBACK', $settings);
?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_CHOOSE_CITY_HEADING')?></td>
</tr>

<tr class="">
    <td width="40%" class="adm-detail-content-cell-l" valign="top">
        <?=Loc::getMessage('TF_LOCATION_CHOOSE_CITY')?>:
    </td>
    <td width="60%" class="adm-detail-content-cell-r" valign="top">
        <ul class="tfl__cities">
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
                        ?> <input type="hidden" value="<?=$defaultCity['ID']?>" name="TF_LOCATION_DEFAULT_CITIES[]"><i></i><?php
                    endif;

                    ?></li>
                <?php endforeach;

            else: ?>
                <li class="empty_location_el"><?=Loc::getMessage('TF_LOCATION_EMPTY_LIST');?></li>
            <? endif;?>
    </td>
</tr>
<?if (Location::getType() == Location::TYPE__SALE):?>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TF_LOCATION_ADD_CITY');?>:
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
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_ADD_CITY_HELP')?></div>
            <script>
                function setCity(cityID) {
                    var ArLocationName = $('#tmp_val_div_' + cityID + '_NAME').text().split(','),
                        cityNAME = ArLocationName[0];

                    $('.empty_location_el').remove();
                    $('.tfl__cities').append('<li data-id="'+cityID+'">'+cityNAME+'<input type="hidden" value="'+cityID+'" name="TF_LOCATION_DEFAULT_CITIES[]"><i></i></li>');
                    $('#LOCATION_tmp select').not('#COUNTRY_tmptmp').remove();
                    $('#COUNTRY_tmptmp option').first().attr('selected', 'selected');
                }

                $(function() {
                    $(document).delegate('.tfl__cities li i', 'click', function() {
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
                     $('.tfl__cities').append('<li data-id="'+locationID+'">'+LocationName+'<input type="hidden" value="'+locationID+'" name="TF_LOCATION_DEFAULT_CITIES[]"><i></i></li>');
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
            <?=Loc::getMessage('TF_LOCATION_DEFAULT_CITIES_S2')?>
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_ADD_CITY_HELP')?></div>

        </td>

    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TF_LOCATION_DEFAULT_CITY')?>:
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <? $APPLICATION->IncludeComponent(
                "bitrix:sale.location.selector.search",
                ".default",
                array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "ID" => $settings['TF_LOCATION_DEFAULT_CITY'],
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
                    $('#TF_LOCATION_DEFAULT_CITY').val(itemId);
                }
            </script>
            <input type="hidden" id="TF_LOCATION_DEFAULT_CITY" name="TF_LOCATION_DEFAULT_CITY" value="">
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_DEFAULT_CITY_HELP')?><br><?=Loc::getMessage('TF_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
<?php else: ?>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top"></td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?=Loc::getMessage('TF_LOCATION_DEFAULT_CITIES_INTERNAL')?>
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
    <tr class="">
        <td width="40%" class="adm-detail-content-cell-l" valign="top">
            <?=Loc::getMessage('TF_LOCATION_DEFAULT_CITY')?>:
        </td>
        <td width="60%" class="adm-detail-content-cell-r" valign="top">
            <?
            $defaultLocation = Location\Internal::getDefault();
            if (isset($defaultLocation['NAME']))
                echo $defaultLocation['NAME'];
            else
                echo Loc::getMessage('TF_LOCATION_DEFAULT_CITY_NONE');
            ?>
            <?=Loc::getMessage('TF_LOCATION_DEFAULT_CITY_INTERNAL')?>
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_DEFAULT_CITY_HELP')?><br><?=Loc::getMessage('TF_LOCATION_ADD_CITY_HELP')?></div>
        </td>
    </tr>
<?php endif; ?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_VISUAL_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_HEADLINK_CLASS"><?=Loc::getMessage('TF_LOCATION_HEADLINK_CLASS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_HEADLINK_CLASS" id="TF_LOCATION_HEADLINK_CLASS" value="<?=$settings['TF_LOCATION_HEADLINK_CLASS']?>">
        <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_HEADLINK_CLASS_HELP')?></div>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
        <label for="TF_LOCATION_POPUP_RADIUS"><?=Loc::getMessage('TF_LOCATION_POPUP_RADIUS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="2" type="text" name="TF_LOCATION_POPUP_RADIUS" id="TF_LOCATION_POPUP_RADIUS" value="<?=$settings['TF_LOCATION_POPUP_RADIUS']?>"> px.
        <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_POPUP_RADIUS_HELP')?></div>
    </td>
</tr>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_STRINGS_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_LOCATION_POPUP_HEADER"><?=Loc::getMessage('TF_LOCATION_LOCATION_POPUP_HEADER') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_LOCATION_POPUP_HEADER" id="TF_LOCATION_LOCATION_POPUP_HEADER" value="<?=$settings['TF_LOCATION_LOCATION_POPUP_HEADER']?>">
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_LOCATION_POPUP_PLACEHOLDER"><?=Loc::getMessage('TF_LOCATION_LOCATION_POPUP_PLACEHOLDER') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_LOCATION_POPUP_PLACEHOLDER" id="TF_LOCATION_LOCATION_POPUP_PLACEHOLDER" value="<?=$settings['TF_LOCATION_LOCATION_POPUP_PLACEHOLDER']?>">
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_LOCATION_POPUP_NO_FOUND"><?=Loc::getMessage('TF_LOCATION_LOCATION_POPUP_NO_FOUND') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_LOCATION_POPUP_NO_FOUND" id="TF_LOCATION_LOCATION_POPUP_NO_FOUND" value="<?=$settings['TF_LOCATION_LOCATION_POPUP_NO_FOUND']?>">
    </td>
</tr>
<?	$tab->EndTab();