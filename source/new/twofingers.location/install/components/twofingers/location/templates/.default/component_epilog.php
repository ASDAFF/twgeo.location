<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 21.03.2019
 * Time: 11:56
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */
$asset = \Bitrix\Main\Page\Asset::getInstance();
if($arResult['SETTINGS']['TF_LOCATION_JQUERY_INCLUDE'] != "N")
    $asset->addJs($templateFolder . '/js/jquery-3.3.1.min.js');

$asset->addJs($templateFolder . '/js/jquery.mousewheel.min.js');
$asset->addJs($templateFolder . '/js/jquery.nicescroll.min.js');
//$asset->addJs($templateFolder . '/js/jquery.slimscroll.min.js');

