<?

use Bitrix\Main\Localization\Loc;
use TwoFingers\Location\Helper\Options;

$tab->BeginNextTab();

?>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_BEHAVOUR_HEADING')?></td>
</tr>
<? Options::showSelectBoxRow('TF_LOCATION_SHOW_CONFIRM_POPUP', $settings); ?>

<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_VISUAL_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
        <label for="TF_LOCATION_CONFIRM_POPUP_RADIUS"><?=Loc::getMessage('TF_LOCATION_POPUP_RADIUS') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="2" type="text" name="TF_LOCATION_CONFIRM_POPUP_RADIUS" id="TF_LOCATION_CONFIRM_POPUP_RADIUS" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_RADIUS']?>"> px.
        <div class="tfl-help"><?= Loc::getMessage('TF_LOCATION_POPUP_RADIUS_HELP')?></div>
    </td>
</tr>
<tr>
    <td colspan="2">
        <table class="adm-detail-content-table edit-table">
            <tr>
                <th></th>
                <th align="left" style="text-align: left"><?=Loc::getMessage('TF_LOCATION_CONFIRM_BUTTON')?></th>
                <th align="left" style="text-align: left"><?=Loc::getMessage('TF_LOCATION_CANCEL_BUTTON')?></th>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TF_LOCATION_COLOR') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR" id="TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR" id="TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TF_LOCATION_COLOR_HOVER') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER" id="TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER" id="TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_SECONDARY_COLOR_HOVER']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label ><?=Loc::getMessage('TF_LOCATION_BG') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG" id="TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG" id="TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
            <tr>
                <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
                    <label><?=Loc::getMessage('TF_LOCATION_BG_HOVER') ?>:</label>
                </td>
                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER" id="TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>

                <td width="30%" class="adm-detail-content-cell-r">
                    <input size="40" type="color" name="TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER" id="TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_SECONDARY_BG_HOVER']?>">
                    <span class="tfl-help"><?=Loc::getMessage('TF_LOCATION_COLOR_HELP')?></span>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr class="heading">
    <td colspan="2"><?=Loc::getMessage('TF_LOCATION_STRINGS_HEADING')?></td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_CONFIRM_POPUP_TEXT"><?=Loc::getMessage('TF_LOCATION_CONFIRM_POPUP_TEXT') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_CONFIRM_POPUP_TEXT" id="TF_LOCATION_CONFIRM_POPUP_TEXT" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_TEXT']?>">
        <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_CONFIRM_POPUP_TEXT_HELP')?></div>
    </td>
</tr>
<tr>
    <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
        <label for="TF_LOCATION_CONFIRM_POPUP_TEXT"><?=Loc::getMessage('TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT') ?>:</label>
    </td>
    <td width="60%" class="adm-detail-content-cell-r">
        <input size="40" type="text" name="TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT" id="TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT" value="<?=$settings['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT']?>">
        <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP')?></div>
    </td>
</tr>
<?	$tab->EndTab();?>