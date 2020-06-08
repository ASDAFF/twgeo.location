<?	$tab->BeginNextTab();

use Bitrix\Main\Localization\Loc; ?>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TF_LOCATION_TEMPLATE"><?=Loc::getMessage('TF_LOCATION_TEMPLATE') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TF_LOCATION_TEMPLATE" id="TF_LOCATION_TEMPLATE" value="Y" <?if ($settings['TF_LOCATION_TEMPLATE'] == 'Y'):?> checked<?endif?>>
            <div class="tfl-help"><?=Loc::getMessage('TF_LOCATION_TEMPLATE_HELP')?></div>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TF_LOCATION_DE"><?=Loc::getMessage('TF_LOCATION_DE') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TF_LOCATION_DELIVERY" id="TF_LOCATION_DE" value="Y" <?if ($settings['TF_LOCATION_DELIVERY'] == 'Y'):?> checked<?endif?>>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l">
            <label for="TF_LOCATION_DE"><?=Loc::getMessage('TF_LOCATION_DELIVERY_ZIP') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="TF_LOCATION_DELIVERY_ZIP" id="TF_LOCATION_DELIVERY_ZIP" value="Y" <?if ($settings['TF_LOCATION_DELIVERY_ZIP'] == 'Y'):?> checked<?endif?>>
            <div class="tfl-help"><?= Loc::getMessage('TF_LOCATION_DELIVERY_ZIP_HELP')?></div>
        </td>
    </tr>
    <tr>
        <td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
            <label for="TF_LOCATION_ORDERLINK_CLASS"><?=Loc::getMessage('TF_LOCATION_ORDERLINK_CLASS') ?>:</label>
        </td>
        <td width="60%" class="adm-detail-content-cell-r">
            <input size="40" type="text" name="TF_LOCATION_ORDERLINK_CLASS" id="TF_LOCATION_ORDERLINK_CLASS" value="<?=$settings['TF_LOCATION_ORDERLINK_CLASS']?>">
        </td>
    </tr>
<?	$tab->EndTab();?>