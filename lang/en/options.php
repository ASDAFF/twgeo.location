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
$MESS['TWG_LOCATION_SETTINGS_TAB_TITLE'] = "Настройки компонента";
$MESS['TWG_LOCATION_SETTINGS_TAB'] = 'Настройки определения местоположения';

$MESS['TWG_LOCATION_MAIN_SECTIONS'] = 'Общие настройки';
$MESS['TWG_LOCATION_SALE_SECTIONS'] = 'Настройки оформления заказа';
$MESS['TWG_LOCATION_DE'] = 'Устанавливать местоположение при оформлении заказа';
$MESS['TWG_LOCATION_DELIVERY_ZIP'] = 'Автоматически менять индекс при изменении местоположения';
$MESS['TWG_LOCATION_DELIVERY_ZIP_HELP'] = 'Некотрые службы доставки используют индекс в своих расчетах.';
$MESS['TWG_LOCATION_TEMPLATE'] = 'Подключить шаблон выбора местоположения';
$MESS['TWG_LOCATION_TEMPLATE_HELP'] = 'Будет использован вместо стандартного выбора местоположений';
$MESS['TWG_LOCATION_ONUNKNOWN'] = 'Открывать попап со списком местоположений, если город не определен';
$MESS['TWG_LOCATION_SHOW_CONFIRM_POPUP'] = 'Открывать попап подтверждения местоположения';
$MESS['TWG_LOCATION_CONFIRM_POPUP_TEXT'] = 'Текст подтверждения';
$MESS['TWG_LOCATION_CONFIRM_POPUP_TEXT_HELP'] = '— #location# будет заменено на название населенного пункта<br>— поддерживаются html-теги';
$MESS['TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT'] = 'Текст, если местоположение определить не удалось';
$MESS['TWG_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP'] = 'Будет выведен, если определить местоположение не удалось';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR']        = 'Цвет текста кнопки подтверждения';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HELP']   = '#rrggbb';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER']        = 'Цвет текста кнопки подтверждения при наведении';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER_HELP']   = '#rrggbb';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG']           = 'Фон кнопки подтверждения';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER']           = 'Фон кнопки подтверждения при наведении';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HELP']      = '#rrggbb';
$MESS['TWG_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER_HELP']      = '#rrggbb';
$MESS['TWG_LOCATION_CALLBACK'] = 'Запускать javascript-функцию после выбора местоположения';
$MESS['TWG_LOCATION_CALLBACK_HELP'] = 'В названии и аргументах функции можно использовать плейсхолдеры:<ul><li><b>#TWG_LOCATION_CITY_ID#</b> - ID выбранного местоположения</li><li><b>#TWG_LOCATION_CITY_NAME#</b> - Название выбранного местоположения</li></ul>Например, onSelectLocation(\'#TWG_LOCATION_CITY_ID#\',\'#TWG_LOCATION_CITY_NAME#\');';
$MESS['TWG_LOCATION_HEADLINK_CLASS'] = 'Добавить класс для ссылки';
$MESS['TWG_LOCATION_HEADLINK_CLASS_HELP'] = 'Кроме оформления заказа';
$MESS['TWG_LOCATION_ORDERLINK_CLASS'] = 'Добавить класс для ссылки в оформлении заказа';
$MESS['TWG_LOCATION_CHOOSE_CITY'] = 'Избранные местоположения';

$MESS['TWG_LOCATION_ADD_CITY_HELP'] = 'После изменения избранных местоположений необходимо <a href="/bitrix/admin/cache.php?lang=' . LANGUAGE_ID . '" target="_blank">сбросить кеш</a>';
$MESS['TWG_LOCATION_DEFAULT_CITIES_S2'] = '<a target="_blank" href="/bitrix/admin/sale_location_default_list.php?lang=' . LANGUAGE_ID . '">выбрать</a>';
$MESS['TWG_LOCATION_DEFAULT_LOCATION'] = 'Настройки попапа выбора местоположений';
$MESS['TWG_LOCATION_CONFIRM_LOCATION'] = 'Настройки попапа подтверждения местоположения';
$MESS['TWG_LOCATION_HEADLINK_TEXT'] = 'Текст перед ссылкой';
$MESS['TWG_LOCATION_LOCATION_POPUP_HEADER']      = 'Заголовок';
$MESS['TWG_LOCATION_LOCATION_POPUP_PLACEHOLDER'] = 'Плейсхолдер в строке поиска';
$MESS['TWG_LOCATION_POPUP_RADIUS'] = 'Радиус скругления углов';
$MESS['TWG_LOCATION_JQUERY_INCLUDE'] = 'Подключать JQuery';
$MESS['TWG_LOCATION_JQUERY_INCLUDE_HELP'] = 'Нажмите эту галочку, если в на Вашем сайте не использыется JavaScript-библиотека JQuery';
$MESS['TWG_LOCATION_RELOAD'] = 'Перезагружать страницу после выбора местоположения';
$MESS['TWG_LOCATION_SHOW_VILLAGES']          = 'Добавлять в список местоположений деревни';