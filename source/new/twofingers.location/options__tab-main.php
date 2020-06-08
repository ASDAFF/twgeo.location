<?

use TwoFingers\Location\Helper\Options;
use Bitrix\Main\Localization\Loc;

$tab->BeginNextTab(); ?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TF_LOCATION_VISUAL_HEADING')?></td>
    </tr>
    <?php
    Options::showCheckboxRow('TF_LOCATION_JQUERY_INCLUDE', $settings);
    Options::showTextRow('TF_LOCATION_HEADLINK_TEXT', $settings);
    Options::showTextRow('TF_LOCATION_MOBILE_WIDTH', $settings);
    ?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TF_LOCATION_REDIRECTING_HEADING')?></td>
    </tr>
    <? Options::showSelectBoxRow('TF_LOCATION_REDIRECT', $settings);?>
    <tr class="heading">
        <td colspan="2"><?=Loc::getMessage('TF_LOCATION_LOCATIONS_HEADING')?></td>
    </tr>
    <?
    Options::showTextRow('TF_LOCATION_COOKIE_LIFETIME', $settings);
    Options::showCheckboxRow('TF_LOCATION_SXGEO_MEMORY', $settings);
    ?>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text" >
            <label for="TF_LOCATION_UPDATE_SX"><?=Loc::getMessage('TF_LOCATION_UPDATE_SX') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="submit" value="<?=Loc::getMessage('TF_LOCATION_UPDATE_SX_SUBMIT') ?>" name="TF_LOCATION_UPDATE_SX">
        </td>
    </tr>
<? $tab->EndTab();