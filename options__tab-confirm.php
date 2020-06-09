<?
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use Bitrix\Main\Localization\Loc;
use TWGeo\Location\Helper\Options;

$tab->BeginNextTab();

?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_BEHAVOUR_HEADING')?></td>
</tr>
<? Options::showSelectBoxRow('TWG_LOCATION_SHOW_CONFIRM_POPUP', $settings); ?>

<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_VISUAL_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
        <label for="TWG_LOCATION_CONFIRM_POPUP_RADIUS"><?=Loc::getMessage('TWG_LOCATION_POPUP_RADIUS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="2" type="text" name="TWG_LOCATION_CONFIRM_POPUP_RADIUS" id="TWG_LOCATION_CONFIRM_POPUP_RADIUS" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_RADIUS']?>"> px.
        <div class="twgl-help"><?= Loc::getMessage('TWG_LOCATION_POPUP_RADIUS_HELP')?></div>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table class="adm-detail-content-table edit-table">
            <tr>
                <th></th>
                <th align="left" style="text-align: left"><?=Loc::getMessage('TWG_LOCATION_CONFIRM_BUTTON')?></th>
                <th align="left" style="text-align: left"><?=Loc::getMessage('TWG_LOCATION_CANCEL_BUTTON')?></th>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TWG_LOCATION_COLOR') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR" id="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR" id="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TWG_LOCATION_COLOR_HOVER') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER" id="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER" id="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label ><?=Loc::getMessage('TWG_LOCATION_BG') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG" id="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG" id="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TWG_LOCATION_BG_HOVER') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER" id="TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER" id="TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER']?>">
                    <span class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TWG_LOCATION_STRINGS_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_CONFIRM_POPUP_TEXT"><?=Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_TEXT') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_CONFIRM_POPUP_TEXT" id="TWG_LOCATION_CONFIRM_POPUP_TEXT" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_TEXT']?>">
        <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_TEXT_HELP')?></div>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TWG_LOCATION_CONFIRM_POPUP_TEXT"><?=Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT" id="TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT" value="<?=$settings['TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT']?>">
        <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP')?></div>
    </td>
</tr>
<?	$tab->EndTab();?>