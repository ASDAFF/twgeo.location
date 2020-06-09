<?php
/**
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.03.2019
 * Time: 14:50
 *
 * 
 */
use \TWGeo\Location\Iblock;
if (!\Bitrix\Main\Loader::includeModule('twgeo.location'))
    return;

$MESS['TWG_LOCATION_MAIN_SECTIONS'] = 'Общие настройки';
$MESS['TWG_LOCATION_BEHAVOUR_HEADING'] = 'Поведение';
$MESS['TWG_LOCATION_LOCATIONS_HEADING'] = 'Местоположения';
$MESS['TWG_LOCATION_REDIRECTING_HEADING'] = 'Переадресация';

$MESS['TWG_LOCATION_DE'] = 'Устанавливать местоположение при оформлении заказа';
$MESS['TWG_LOCATION_DELIVERY_ZIP'] = 'Автоматически менять индекс при изменении местоположения';
$MESS['TWG_LOCATION_DELIVERY_ZIP_HELP'] = 'Некотрые службы доставки используют индекс в своих расчетах';
$MESS['TWG_LOCATION_TEMPLATE'] = 'Подключить шаблон выбора местоположения';
$MESS['TWG_LOCATION_TEMPLATE_HELP'] = 'Будет использован вместо стандартного выбора местоположений';
$MESS['TWG_LOCATION_ONUNKNOWN'] = 'Если город не определен, то открывать автоматически';
$MESS['TWG_LOCATION_SHOW_CONFIRM_POPUP'] = 'Автоматически открывать';
$MESS['TWG_LOCATION_LOAD_LOCATIONS_all'] = 'Все местоположения и местоположения по-умолчанию';
$MESS['TWG_LOCATION_LOAD_LOCATIONS_cities'] = 'Города и местоположения по-умолчанию';
$MESS['TWG_LOCATION_LOAD_LOCATIONS_defaults'] = 'Только местоположения по-умолчанию';
$MESS['TWG_LOCATION_LOAD_LOCATIONS'] = 'Сразу загружать';
$MESS['TWG_LOCATION_LOAD_LOCATIONS_HELP'] = 'Если загрузка всех местоположений замедляет работу сайта, то выберите режим "' . $MESS['TWG_LOCATION_LOAD_LOCATIONS_cities'] . '" или "' . $MESS['TWG_LOCATION_LOAD_LOCATIONS_defaults'] . '". Подходящие местоположения будут загружены во время поиска.';

$MESS['TWG_LOCATION_CONFIRM_POPUP_TEXT'] = 'Текст подтверждения';
$MESS['TWG_LOCATION_CONFIRM_POPUP_TEXT_HELP'] = '— #location# будет заменено на название населенного пункта<br>— поддерживаются html-теги';
$MESS['TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT'] = 'Текст, если местоположение определить не удалось';
$MESS['TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP'] = 'Будет выведен, если определить местоположение не удалось';
$MESS['TWG_LOCATION_COLOR']        = 'Цвет текста';
$MESS['TWG_LOCATION_COLOR_HELP']   = '#rrggbb';
$MESS['TWG_LOCATION_COLOR_HOVER']        = 'Цвет текста при наведении';

$MESS['TWG_LOCATION_REDIRECT']        = 'Автоматическая переадресация на домен/поддомен';
$MESS['TWG_LOCATION_REDIRECT_HELP']   = 'Осуществляется только если для соотвествующего <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Content::getId() .'&type=' . Iblock::TYPE .'&lang=' . LANGUAGE_ID .'&find_section_section=0">местоположения</a> задан <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Domain::getId() .'&type=' . Iblock::TYPE .'&lang=' . LANGUAGE_ID .'&find_section_section=0">домен</a>';

$MESS['TWG_LOCATION_BG']           = 'Цвет фона';
$MESS['TWG_LOCATION_BG_HOVER']           = 'Цвет фона при наведении';
$MESS['TWG_LOCATION_MOBILE_WIDTH']      = 'Ширина экрана, с которой считается, что устройство мобильное';
$MESS['TWG_LOCATION_MOBILE_WIDTH_POST_INPUT']      = 'px.';
$MESS['TWG_LOCATION_CALLBACK'] = 'Запускать javascript-функцию после выбора местоположения';
$MESS['TWG_LOCATION_CALLBACK_HELP'] = 'В названии и аргументах функции можно использовать плейсхолдеры:<ul><li><b>#TWG_LOCATION_CITY_ID#</b> - ID выбранного местоположения</li><li><b>#TWG_LOCATION_CITY_NAME#</b> - Название выбранного местоположения</li></ul>Например, onSelectLocation(\'#TWG_LOCATION_CITY_ID#\',\'#TWG_LOCATION_CITY_NAME#\');';
$MESS['TWG_LOCATION_HEADLINK_CLASS'] = 'Добавить класс для ссылки';
$MESS['TWG_LOCATION_HEADLINK_CLASS_HELP'] = 'Кроме оформления заказа';
$MESS['TWG_LOCATION_ORDERLINK_CLASS'] = 'Добавить класс для ссылки в оформлении заказа';
$MESS['TWG_LOCATION_CHOOSE_CITY_HEADING'] = 'Избранные местоположения';
$MESS['TWG_LOCATION_CHOOSE_CITY'] = 'Избранные местоположения';
$MESS['TWG_LOCATION_STRINGS_HEADING'] = 'Переопределение строковых констант';
$MESS['TWG_LOCATION_VISUAL_HEADING'] = 'Внешний вид';
$MESS['TWG_LOCATION_CONFIRM_BUTTON'] = 'Кнопка подтверждения';
$MESS['TWG_LOCATION_CANCEL_BUTTON'] = 'Кнопка отмены/выбора';

$MESS['TWG_LOCATION_ADD_CITY_HELP'] = 'После изменения необходимо <a href="/bitrix/admin/cache.php?lang=' . LANGUAGE_ID . '" target="_blank">сбросить кеш</a>';
$MESS['TWG_LOCATION_DEFAULT_CITIES_S2'] = '<a target="_blank" href="/bitrix/admin/sale_location_default_list.php?lang=' . LANGUAGE_ID . '">изменить список избранных местоположений</a>';
$MESS['TWG_LOCATION_DEFAULT_CITIES_INTERNAL'] = '<a target="_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Location::getId() . '&type=twg_location&lang=' . LANGUAGE_ID . '&find_section_section=0">изменить список</a>';
$MESS['TWG_LOCATION_DEFAULT_CITY']       = 'Местоположение по-умолчанию';
$MESS['TWG_LOCATION_DEFAULT_CITY_HELP']  = 'Будет выведено, если не удастся определить текущее местоположение. Можно оставить пустым.';
$MESS['TWG_LOCATION_DEFAULT_CITY_INTERNAL'] = '<a target="_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Location::getId() . '&type=twg_location&lang=' . LANGUAGE_ID . '&find_section_section=0">изменить</a>';
$MESS['TWG_LOCATION_DEFAULT_CITY_NONE']  = '[не выбрано]';


$MESS['TWG_LOCATION_HEADLINK_TEXT']          = 'Текст перед ссылкой';
$MESS['TWG_LOCATION_LOCATION_POPUP_HEADER']  = 'Заголовок';
$MESS['TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER'] = 'Плейсхолдер в строке поиска';
$MESS['TWG_LOCATION_LOCATION_POPUP_NO_FOUND']= 'Надпись, если не найдено ни одного нас. пункта';
$MESS['TWG_LOCATION_POPUP_RADIUS']           = 'Радиус скругления углов';
$MESS['TWG_LOCATION_POPUP_RADIUS_HELP']      = 'Для десктоп-версии';
$MESS['TWG_LOCATION_JQUERY_INCLUDE']         = 'Подключать JQuery';
$MESS['TWG_LOCATION_JQUERY_INCLUDE_HELP']    = 'Нажмите эту галочку, если в на Вашем сайте не использыется JavaScript-библиотека JQuery';
$MESS['TWG_LOCATION_COOKIE_LIFETIME']        = 'Хранить местоположение';
$MESS['TWG_LOCATION_COOKIE_LIFETIME_POST_INPUT']   = 'дн.';
$MESS['TWG_LOCATION_COOKIE_LIFETIME_HELP']   = 'Если указать ноль, то после закрытия браузера местоположение будет сброшено';
$MESS['TWG_LOCATION_RELOAD']                 = 'Перезагружать страницу после выбора местоположения';
$MESS['TWG_LOCATION_RELOAD_HELP']            = 'Используйте, если после изменения местоположения необходимо обновить какие-либо данные на странице.<br>Если для местоположений указана переадресация, то произойдёт она, а не перезагрузка страницы.';
$MESS['TWG_LOCATION_SHOW_VILLAGES']          = 'Добавлять деревни в список местоположений';
$MESS['TWG_LOCATION_SHOW_VILLAGES_HELP']     = 'Может вызвать замедление загрузки списка при большом количестве деревень';
$MESS['TWG_LOCATION_SXGEO_MEMORY']           = 'Загружать базу местоположений в оперативную память';
$MESS['TWG_LOCATION_SXGEO_MEMORY_HELP']      = 'Ускоряет определение местоположения, но требует больше ресурсов.<br>Если перестанет хватать памяти, попробуйте отключить эту опцию.';
$MESS['TWG_LOCATION_UPDATE_SX']              = 'Обновить базу местоположений';
$MESS['TWG_LOCATION_UPDATE_SX_SUBMIT']       = 'Обновить';