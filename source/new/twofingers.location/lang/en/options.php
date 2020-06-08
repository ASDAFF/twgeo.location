<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09.03.2019
 * Time: 14:50
 *
 *
 */
$MESS['TF_LOCATION_SETTINGS_TAB_TITLE'] = "Настройки компонента";
$MESS['TF_LOCATION_SETTINGS_TAB'] = 'Настройки определения местоположения';

$MESS['TF_LOCATION_MAIN_SECTIONS'] = 'Общие настройки';
$MESS['TF_LOCATION_SALE_SECTIONS'] = 'Настройки оформления заказа';
$MESS['TF_LOCATION_DE'] = 'Устанавливать местоположение при оформлении заказа';
$MESS['TF_LOCATION_DELIVERY_ZIP'] = 'Автоматически менять индекс при изменении местоположения';
$MESS['TF_LOCATION_DELIVERY_ZIP_HELP'] = 'Некотрые службы доставки используют индекс в своих расчетах.';
$MESS['TF_LOCATION_TEMPLATE'] = 'Подключить шаблон выбора местоположения';
$MESS['TF_LOCATION_TEMPLATE_HELP'] = 'Будет использован вместо стандартного выбора местоположений';
$MESS['TF_LOCATION_ONUNKNOWN'] = 'Открывать попап со списком местоположений, если город не определен';
$MESS['TF_LOCATION_SHOW_CONFIRM_POPUP'] = 'Открывать попап подтверждения местоположения';
$MESS['TF_LOCATION_CONFIRM_POPUP_TEXT'] = 'Текст подтверждения';
$MESS['TF_LOCATION_CONFIRM_POPUP_TEXT_HELP'] = '— #location# будет заменено на название населенного пункта<br>— поддерживаются html-теги';
$MESS['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT'] = 'Текст, если местоположение определить не удалось';
$MESS['TF_LOCATION_CONFIRM_POPUP_ERROR_TEXT_HELP'] = 'Будет выведен, если определить местоположение не удалось';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR']        = 'Цвет текста кнопки подтверждения';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HELP']   = '#rrggbb';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER']        = 'Цвет текста кнопки подтверждения при наведении';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_COLOR_HOVER_HELP']   = '#rrggbb';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG']           = 'Фон кнопки подтверждения';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER']           = 'Фон кнопки подтверждения при наведении';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HELP']      = '#rrggbb';
$MESS['TF_LOCATION_CONFIRM_POPUP_PRIMARY_BG_HOVER_HELP']      = '#rrggbb';
$MESS['TF_LOCATION_CALLBACK'] = 'Запускать javascript-функцию после выбора местоположения';
$MESS['TF_LOCATION_CALLBACK_HELP'] = 'В названии и аргументах функции можно использовать плейсхолдеры:<ul><li><b>#TF_LOCATION_CITY_ID#</b> - ID выбранного местоположения</li><li><b>#TF_LOCATION_CITY_NAME#</b> - Название выбранного местоположения</li></ul>Например, onSelectLocation(\'#TF_LOCATION_CITY_ID#\',\'#TF_LOCATION_CITY_NAME#\');';
$MESS['TF_LOCATION_HEADLINK_CLASS'] = 'Добавить класс для ссылки';
$MESS['TF_LOCATION_HEADLINK_CLASS_HELP'] = 'Кроме оформления заказа';
$MESS['TF_LOCATION_ORDERLINK_CLASS'] = 'Добавить класс для ссылки в оформлении заказа';
$MESS['TF_LOCATION_CHOOSE_CITY'] = 'Избранные местоположения';

$MESS['TF_LOCATION_ADD_CITY_HELP'] = 'После изменения избранных местоположений необходимо <a href="/bitrix/admin/cache.php?lang=' . LANGUAGE_ID . '" target="_blank">сбросить кеш</a>';
$MESS['TF_LOCATION_DEFAULT_CITIES_S2'] = '<a target="_blank" href="/bitrix/admin/sale_location_default_list.php?lang=' . LANGUAGE_ID . '">выбрать</a>';
$MESS['TF_LOCATION_DEFAULT_LOCATION'] = 'Настройки попапа выбора местоположений';
$MESS['TF_LOCATION_CONFIRM_LOCATION'] = 'Настройки попапа подтверждения местоположения';
$MESS['TF_LOCATION_HEADLINK_TEXT'] = 'Текст перед ссылкой';
$MESS['TF_LOCATION_LOCATION_POPUP_HEADER']      = 'Заголовок';
$MESS['TF_LOCATION_LOCATION_POPUP_PLACEHOLDER'] = 'Плейсхолдер в строке поиска';
$MESS['TF_LOCATION_POPUP_RADIUS'] = 'Радиус скругления углов';
$MESS['TF_LOCATION_JQUERY_INCLUDE'] = 'Подключать JQuery';
$MESS['TF_LOCATION_JQUERY_INCLUDE_HELP'] = 'Нажмите эту галочку, если в на Вашем сайте не использыется JavaScript-библиотека JQuery';
$MESS['TF_LOCATION_RELOAD'] = 'Перезагружать страницу после выбора местоположения';
$MESS['TF_LOCATION_SHOW_VILLAGES']          = 'Добавлять в список местоположений деревни';