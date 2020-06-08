<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 12.12.2019
 * Time: 17:26
 *
 * 
 */

namespace TwoFingers\Location\Helper;

use Bitrix\Main\Localization\Loc;
use TwoFingers\Location\Settings;

/**
 * Class Options
 *
 * @package TwoFingers\Location
 *
 */
class Options
{
    /**
     * @param       $code
     * @param       $settings
     * @param array $settingsMap
     */
    public static function showTextRow($code, $settings)
    {
        ?><tr><?php
            self::showLabel($code);
            self::showInputText($code, $settings);
        ?></tr><?php
    }

    /**
     * @param $code
     * @param $settings
     * 
     */
    public static function showCheckboxRow($code, $settings)
    {
        ?><tr><?php
            self::showLabel($code);
            self::showInputCheckbox($code, $settings);
        ?></tr><?php
    }

    /**
     * @param $code
     */
    public static function showLabel($code)
    {
        ?><td width="40%" class="adm-detail-content-cell-l adm-detail-content-text">
            <label for="<?=$code?>"><?=Loc::getMessage($code) ?>:</label>
        </td><?php
    }

    public static function showSelectBoxRow($code, $settings)
    {
        ?><tr><?php
            self::showLabel($code);
            self::showInputSelectBox($code, $settings);
        ?></tr><?php
    }

    /**
     * @param       $code
     * @param       $settings
     */
    public static function showInputText($code, $settings)
    {
        $settingsMap= Settings::getMap();

        ?><td width="60%" class="adm-detail-content-cell-r">
            <input size="<?=isset($settingsMap[$code]['size']) ? $settingsMap[$code]['size'] : '40'?>" type="text" name="<?=$code?>" id="<?=$code?>" value="<?=$settings[$code]?>">
            <?php if (strlen(Loc::getMessage($code . '_POST_INPUT'))): ?>
                <?=Loc::getMessage($code . '_POST_INPUT');?>
            <?php endif; ?>
            <?php if (strlen(Loc::getMessage($code . '_HELP'))): ?>
                <div class="tfl-help"><?=Loc::getMessage($code . '_HELP')?></div>
            <?php endif;?>
        </td><?php
    }

    /**
     * @param $code
     * @param $settings
     * 
     */
    public static function showInputSelectBox($code, $settings)
    {
        $settingsMap= Settings::getMap();
        ?>

        <td width="60%" class="adm-detail-content-cell-r">
            <select name="<?=$code?>" id="<?=$code?>">
                <?php foreach ($settingsMap[$code]['options'] as $value => $name ):?>
                    <option value="<?=$value?>"<?if ($settings[$code] == $value):?> selected<?endif?>><?=$name?></option>
                <?php endforeach;?>
            </select>
            <?php if (strlen(Loc::getMessage($code . '_HELP'))): ?>
                <div class="tfl-help"><?=Loc::getMessage($code . '_HELP')?></div>
            <?php endif;?>
        </td><?php
    }

    /**
     * @param $code
     * @param $settings
     * 
     */
    public static function showInputCheckbox($code, $settings)
    {
        ?><td width="60%" class="adm-detail-content-cell-r">
            <input type="checkbox" name="<?=$code?>" id="<?=$code?>" value="Y" <?if ($settings[$code] == 'Y'):?> checked<?endif?>>
            <?php if (strlen(Loc::getMessage($code . '_HELP'))): ?>
                <div class="tfl-help"><?=Loc::getMessage($code . '_HELP')?></div>
            <?php endif;?>
        </td><?php
    }
}