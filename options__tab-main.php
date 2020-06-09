<?
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use TWGeo\Location\Helper\Options;
use Bitrix\Main\Localization\Loc;

$tab->BeginNextTab(); ?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_VISUAL_HEADING')?></td>
    </tr>
    <?php
    Options::showCheckboxRow('TWG_LOCATION_JQUERY_INCLUDE', $settings);
    Options::showTextRow('TWG_LOCATION_HEADLINK_TEXT', $settings);
    Options::showTextRow('TWG_LOCATION_MOBILE_WIDTH', $settings);
    ?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_REDIRECTING_HEADING')?></td>
    </tr>
    <? Options::showSelectBoxRow('TWG_LOCATION_REDIRECT', $settings);?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_LOCATIONS_HEADING')?></td>
    </tr>
    <?
    Options::showTextRow('TWG_LOCATION_COOKIE_LIFETIME', $settings);
    Options::showCheckboxRow('TWG_LOCATION_SXGEO_MEMORY', $settings);
    ?>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
            <label for="TWG_LOCATION_UPDATE_SX"><?=Loc::getMessage('TWG_LOCATION_UPDATE_SX') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="submit" value="<?=Loc::getMessage('TWG_LOCATION_UPDATE_SX_SUBMIT') ?>" name="TWG_LOCATION_UPDATE_SX">
        </td>
    </tr>
<? $tab->EndTab();