<?	$tab->BeginNextTab();
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

use Bitrix\Main\Localization\Loc; ?>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TWG_LOCATION_TEMPLATE"><?=Loc::getMessage('TWG_LOCATION_TEMPLATE') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TWG_LOCATION_TEMPLATE" id="TWG_LOCATION_TEMPLATE" value="Y" <?if ($settings['TWG_LOCATION_TEMPLATE'] == 'Y'):?> checked<?endif?>>
            <div class="twgl-help"><?=Loc::getMessage('TWG_LOCATION_TEMPLATE_HELP')?></div>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TWG_LOCATION_DE"><?=Loc::getMessage('TWG_LOCATION_DE') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TWG_LOCATION_DELIVERY" id="TWG_LOCATION_DE" value="Y" <?if ($settings['TWG_LOCATION_DELIVERY'] == 'Y'):?> checked<?endif?>>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TWG_LOCATION_DE"><?=Loc::getMessage('TWG_LOCATION_DELIVERY_ZIP') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TWG_LOCATION_DELIVERY_ZIP" id="TWG_LOCATION_DELIVERY_ZIP" value="Y" <?if ($settings['TWG_LOCATION_DELIVERY_ZIP'] == 'Y'):?> checked<?endif?>>
            <div class="twgl-help"><?= Loc::getMessage('TWG_LOCATION_DELIVERY_ZIP_HELP')?></div>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
            <label for="TWG_LOCATION_ORDERLINK_CLASS"><?=Loc::getMessage('TWG_LOCATION_ORDERLINK_CLASS') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input size="40" type="text" name="TWG_LOCATION_ORDERLINK_CLASS" id="TWG_LOCATION_ORDERLINK_CLASS" value="<?=$settings['TWG_LOCATION_ORDERLINK_CLASS']?>">
        </td>
    </tr>
<?	$tab->EndTab();?>