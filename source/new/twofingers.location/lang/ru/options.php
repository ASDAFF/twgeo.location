<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.03.2019
 * Time: 14:50
 *
 * 
 */
use \TwoFingers\Location\Iblock;
if (!\Bitrix\Main\Loader::includeModule('twofingers.location'))
    return;

$MESS['TF_LOCATION_MAIN_SECTIONS'] = 'Общие настройки';
$MESS['TF_LOCATION_BEHAVOUR_HEADING'] = 'Поведение';
$MESS['TF_LOCATION_LOCATIONS_HEADING'] = 'Местоположения';
$MESS['TF_LOCATION_REDIRECTING_HEADING'] = 'Переадресация';

$MESS['TF_LOCATION_DE'] = 'Устанавливать местоположение при оформлении заказа';
$MESS['TF_LOCATION_DELIVERY_ZIP'] = 'Автоматически менять индекс при изменении местоположения';
$MESS['TF_LOCATION_DELIVERY_ZIP_HELP'] = 'Некотрые службы доставки используют индекс в своих расчетах';
$MESS['TF_LOCATION_TEMPLATE'] = 'Подключить шаблон выбора местоположения';
$MESS['TF_LOCATION_TEMPLATE_HELP'] = 'Будет использован вместо стандартного выбора местоположений';
$MESS['TF_LOCATION_ONUNKNOWN'] = 'Если город не определен, то открывать автоматически';
$MESS['TF_LOCATION_SHOW_CONFIRM_POPUP'] = 'Автоматически открывать';
$MESS['TF_LOCATION_LOAD_LOCATIONS_all'] = 'Все местоположения и местоположения по-умолчанию';
$MESS['TF_LOCATION_LOAD_LOCATIONS_cities'] = 'Города и местоположения по-умолчанию';
$MESS['TF_LOCATION_LOAD_LOCATIONS_defaults'] = 'Только местоположения по-умолчанию';
$MESS['TF_LOCATION_LOAD_LOCATIONS'] = 'Сразу загружать';
$MESS['TF_LOCATION_LOAD_LOCATIONS_HELP'] = 'Если загрузка всех местоположений замедляет работу сайта, то выберите режим "' . $MESS['TF_LOCATION_LOAD_LOCATIONS_cities'] . '" или "' . $MESS['TF_LOCATION_LOAD_LOCATIONS_defaults'] . '". Подходящие местоположения будут загружены во время поиска.';

$MESS['TF_LOCATION_CONFIRM_POPUP_TEXT'] = 'Текст подтверждения';
$MESS['TF_LOCATION_CONFIRM_POPUP_TEXT_HELP'] = '— #location# будет заменено на название населенного пункта<br>— поддерживаются html-теги';
$MESS['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT'] = 'Текст, если местоположение определить не удалось';
$MESS['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP'] = 'Будет выведен, если определить местоположение не удалось';
$MESS['TF_LOCATION_COLOR']        = 'Цвет текста';
$MESS['TF_LOCATION_COLOR_HELP']   = '#rrggbb';
$MESS['TF_LOCATION_COLOR_HOVER']        = 'Цвет текста при наведении';

$MESS['TF_LOCATION_REDIRECT']        = 'Автоматическая переадресация на домен/поддомен';
$MESS['TF_LOCATION_REDIRECT_HELP']   = 'Осуществляется только если для соотвествующего <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Content::getId() .'&type=' . Iblock::TYPE .'&lang=' . LANGUAGE_ID .'&find_section_section=0">местоположения</a> задан <a href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Domain::getId() .'&type=' . Iblock::TYPE .'&lang=' . LANGUAGE_ID .'&find_section_section=0">домен</a>';

$MESS['TF_LOCATION_BG']           = 'Цвет фона';
$MESS['TF_LOCATION_BG_HOVER']           = 'Цвет фона при наведении';
$MESS['TF_LOCATION_MOBILE_WIDTH']      = 'Ширина экрана, с которой считается, что устройство мобильное';
$MESS['TF_LOCATION_MOBILE_WIDTH_POST_INPUT']      = 'px.';
$MESS['TF_LOCATION_CALLBACK'] = 'Запускать javascript-функцию после выбора местоположения';
$MESS['TF_LOCATION_CALLBACK_HELP'] = 'В названии и аргументах функции можно использовать плейсхолдеры:<ul><li><b>#TF_LOCATION_CITY_ID#</b> - ID выбранного местоположения</li><li><b>#TF_LOCATION_CITY_NAME#</b> - Название выбранного местоположения</li></ul>Например, onSelectLocation(\'#TF_LOCATION_CITY_ID#\',\'#TF_LOCATION_CITY_NAME#\');';
$MESS['TF_LOCATION_HEADLINK_CLASS'] = 'Добавить класс для ссылки';
$MESS['TF_LOCATION_HEADLINK_CLASS_HELP'] = 'Кроме оформления заказа';
$MESS['TF_LOCATION_ORDERLINK_CLASS'] = 'Добавить класс для ссылки в оформлении заказа';
$MESS['TF_LOCATION_CHOOSE_CITY_HEADING'] = 'Избранные местоположения';
$MESS['TF_LOCATION_CHOOSE_CITY'] = 'Избранные местоположения';
$MESS['TF_LOCATION_STRINGS_HEADING'] = 'Переопределение строковых констант';
$MESS['TF_LOCATION_VISUAL_HEADING'] = 'Внешний вид';
$MESS['TF_LOCATION_CONFIRM_BUTTON'] = 'Кнопка подтверждения';
$MESS['TF_LOCATION_CANCEL_BUTTON'] = 'Кнопка отмены/выбора';

$MESS['TF_LOCATION_ADD_CITY_HELP'] = 'После изменения необходимо <a href="/bitrix/admin/cache.php?lang=' . LANGUAGE_ID . '" target="_blank">сбросить кеш</a>';
$MESS['TF_LOCATION_DEFAULT_CITIES_S2'] = '<a target="_blank" href="/bitrix/admin/sale_location_default_list.php?lang=' . LANGUAGE_ID . '">изменить список избранных местоположений</a>';
$MESS['TF_LOCATION_DEFAULT_CITIES_INTERNAL'] = '<a target="_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Location::getId() . '&type=tf_location&lang=' . LANGUAGE_ID . '&find_section_section=0">изменить список</a>';
$MESS['TF_LOCATION_DEFAULT_CITY']       = 'Местоположение по-умолчанию';
$MESS['TF_LOCATION_DEFAULT_CITY_HELP']  = 'Будет выведено, если не удастся определить текущее местоположение. Можно оставить пустым.';
$MESS['TF_LOCATION_DEFAULT_CITY_INTERNAL'] = '<a target="_blank" href="/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=' . Iblock\Location::getId() . '&type=tf_location&lang=' . LANGUAGE_ID . '&find_section_section=0">изменить</a>';
$MESS['TF_LOCATION_DEFAULT_CITY_NONE']  = '[не выбрано]';


$MESS['TF_LOCATION_HEADLINK_TEXT']          = 'Текст перед ссылкой';
$MESS['TF_LOCATION_LOCATION_POPUP_HEADER']  = 'Заголовок';
$MESS['TF_LOCATION_LOCATION_POPUP_PLACEHOLDER'] = 'Плейсхолдер в строке поиска';
$MESS['TF_LOCATION_LOCATION_POPUP_NO_FOUND']= 'Надпись, если не найдено ни одного нас. пункта';
$MESS['TF_LOCATION_POPUP_RADIUS']           = 'Радиус скругления углов';
$MESS['TF_LOCATION_POPUP_RADIUS_HELP']      = 'Для десктоп-версии';
$MESS['TF_LOCATION_JQUERY_INCLUDE']         = 'Подключать JQuery';
$MESS['TF_LOCATION_JQUERY_INCLUDE_HELP']    = 'Нажмите эту галочку, если в на Вашем сайте не использыется JavaScript-библиотека JQuery';
$MESS['TF_LOCATION_COOKIE_LIFETIME']        = 'Хранить местоположение';
$MESS['TF_LOCATION_COOKIE_LIFETIME_POST_INPUT']   = 'дн.';
$MESS['TF_LOCATION_COOKIE_LIFETIME_HELP']   = 'Если указать ноль, то после закрытия браузера местоположение будет сброшено';
$MESS['TF_LOCATION_RELOAD']                 = 'Перезагружать страницу после выбора местоположения';
$MESS['TF_LOCATION_RELOAD_HELP']            = 'Используйте, если после изменения местоположения необходимо обновить какие-либо данные на странице.<br>Если для местоположений указана переадресация, то произойдёт она, а не перезагрузка страницы.';
$MESS['TF_LOCATION_SHOW_VILLAGES']          = 'Добавлять деревни в список местоположений';
$MESS['TF_LOCATION_SHOW_VILLAGES_HELP']     = 'Может вызвать замедление загрузки списка при большом количестве деревень';
$MESS['TF_LOCATION_SXGEO_MEMORY']           = 'Загружать базу местоположений в оперативную память';
$MESS['TF_LOCATION_SXGEO_MEMORY_HELP']      = 'Ускоряет определение местоположения, но требует больше ресурсов.<br>Если перестанет хватать памяти, попробуйте отключить эту опцию.';
$MESS['TF_LOCATION_UPDATE_SX']              = 'Обновить базу местоположений';
$MESS['TF_LOCATION_UPDATE_SX_SUBMIT']       = 'Обновить';