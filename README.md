# twogeo.location

**Установка**

Решение устанавливается стандартно. После установки Вы будете перенаправлены в интерфейс настройки модуля.

Для корректной работы модуля на редакциях «Бизнес» и «Малый бизнес» необходимо, чтобы были загружены местоположения в базу модуля «Интернет-магазин» http://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=42&LESSON_ID=3074&LESSON_PATH=3912.4580.4828.3074#load


Подключение компонента улучшенного выбора местоположений

Вы можете вставить ссылку на выбор местоположения города в шапку сайта. Для этого в нужном месте шаблона добавьте вызов компонента:
```php
<?$APPLICATION->IncludeComponent("twgeo:location","",Array());?>
```
Для вашего удобства, чтобы вам не приходилось вручную править шаблон компонента, мы предусмотрели поля для классов, которые будут присвоены ссылкам вызова всплывающего окна, если вы захотите их кастомизировать.

> Если вы используете модифицированный компонент sale.order.ajax, для того, чтобы использовать улучшенный выбор местоположения при оформлении заказа, необходимо для компонента sale.ajax.locations прописать шаблон tf_location.

**Вызов пользовательской javascript-функции**

В настройках модуля можно вписать JS функцию, которая будет выполняться при выборе города пользователем. В её названии можно использовать плейсхолдеры:

```
#TWG_LOCATION_CITY_ID# - ID выбранного города
#TWG_LOCATION_CITY_NAME# - Имя выбранного города
```


Например: `handleMePlease('#TWG_LOCATION_CITY_ID#', '#TWG_LOCATION_CITY_NAME#');`

**Обработка javascript-события onTFLocationSetLocation**

Также после выбора местоположения генерируется javascript-событие "onTFLocationSetLocation", в которое передаётся DOM-объект выбранного местоположения. Пример обработчика:

```javascript
BX.addCustomEvent("onTFLocationSetLocation", function(location)
{
    var $location = $(location);

    console.log('location id: ' + $location.data('id'));
    console.log('location name: ' + $location.data('name'));
    console.log('location region name: ' + $location.data('region-name'));
});
```

**Получение выбранного местоположения на сайте**

Настройки выбранного местоположения сохраняются в сессию или куки (в зависимости от настроек) и могут быть получены с помощью класса-обертки TWGeo\Location\Storage и использованы в других местах:

```php
use TWGeo\Location\Storage;

if (CModule::IncludeModule('twgeo.location')) {
    echo Storage::getLocationId(); // ID местоположения (из модуля "Интернет-магазин", если удалось соотнести, иначе из базы Sypex Geo)
    echo Storage::getLocationName(); // название местоположения
    echo Storage::getRegionId(); // ID региона из базы Sypex Geo
    echo Storage::getRegionName(); // название региона
    echo Storage::getCountryId(); // ID страны из базы Sypex Geo
    echo Storage::getCountryName(); // название страны
}
```

Для композитного режима:
```php
use TWGeo\Location\Storage;

if (CModule::IncludeModule('twgeo.location')) {

    $frame = new \Bitrix\Main\Page\FrameBuffered("my_dynamic_area");
    $frame->begin();

    echo Storage::getLocationId(); // ID местоположения (из модуля "Интернет-магазин", если удалось соотнести, иначе из базы Sypex Geo)
    echo Storage::getLocationName();  // название местоположения
    
    ...

    $frame->end();
}
```

Для работы с **текущим местоположением** предусмотрен класс TWGeo\Location\Current:
```php
use TWGeo\Location\Current;
use TWGeo\Location\Storage;

if (CModule::IncludeModule('twgeo.location')) {

    $current = Current::getInstance(); // получаем текущее местоположение пользователя
    echo $current->getLocationId(); // ID местоположения  (из модуля "Интернет-магазин", если удалось соотнести, иначе из базы Sypex Geo)
    echo $current->getLocationName(); // название местоположения
    echo $current->getRegionId(); // ID региона из базы Sypex Geo    
    echo $current->getCountryId(); // ID страны из базы Sypex Geo
    echo $current->getCountryName(); // название страны

    var_dump($current->getLocation()); // полная информация о местоположении, полученная из базы SypexGeo


    Storage::setFromCurrent($current); // записываем текущее местоположение в хранилище (сессию или куки, в зависимости от настроек)
}
```

Так же есть возможность получить информацию не только о текущем, но и о любом другом местоположении. Для этого в метод TWGeo\Location\Current::getInstance() первым аргументом необходимо передать ip-адрес.


**Получение информации из инфоблока в зависимости от местоположения**

При установке модуля будет создан инфоблок "Контент" в типе "Местоположения". В этом инфоблоке Вы можете создавать элементы, привязанные в конкретному местоположению по имени или ид. Так же возможна привязка к отдельному сайту.

Обратите внимание, что с данным инфоблоком вы можете работать так же, как и со всеми остальными: заполнять все доступные поля, добавлять и удалять свойства (кроме системных LOCATION_ID и SITE_ID). В возвращаемом элементе будет находиться вся доступная информация. Информация о свойствах будет находиться по ключу 'PROPERTIES'.

Например, необходимо менять телефон в шапке сайта в зависимости от города:

```php
use TWGeo\Location\Current;
use TWGeo\Location\Iblock\Content;

if (CModule::IncludeModule('twgeo.location')) {
    $current = Current::getInstance(); // получаем текущее местоположение пользователя
    $element = Content::getByCurrent($current) // получаем элемент, привязанный к текущему местоположению

    echo $element['PROPERTY']['PHONE']['VALUE']; // выводим телефон
}
```
Обратите внимание, что метод TWGeo\Location\Iblock\Content\getByCurrent сначала пытается найти элемент по id местоположения, в случае неудачи - по имени местоположения и в случае второй неудачи, возвращает дефолтное значение (элемент с кодом default). Вторым аргументом можно передать id сайта. В этом случае у элемента инфоблока также должно быт заполнено свойство SITE_ID.


**Настройка автоматического редиректа на домены/поддомены для выбранных местоположений**

Редирект можно настроить для метоположений, добавленных в инфоблок "Контент" (тип "Местоположения"). Для этого элементу иноблока необходимо добавить домен в свойство "Домен".
> Элемент инфоблока обязательно должен быть связан с местоположением через свойство "ИД местоположения" или название.
Предварительно желаемые домены необходимо добавить в инфоблок "Домены" (тип "Местоположения").


**Пример работы с переменными без использования инфоблока**

Допустим, нам необходимо менять телефон в шапке сайта в зависимости от города. Привяжемся к названию города. Будем показывать один телефон для Москвы и другой телефон для всех остальных городов.

```php
use TWGeo\Location\Storage;

if (\CModule::IncludeModule('twgeo.location')) 
{
   if (Storage::getLocationName() == 'Москва')
      echo "+7 (495) 055-65-19";
   else
      echo "8 800 500 40 30";
}
```

Для композитного режима:

```php
use TWGeo\Location\Storage;

if (\CModule::IncludeModule('twgeo.location')) 
{
    $frame = new \Bitrix\Main\Page\FrameBuffered("my_dynamic_area");
    $frame->begin();

    if (Storage::getLocationName() == 'Москва')
        echo "+7 (495) 055-65-19";
    else
        echo "8 800 500 40 30";

    $frame->end();
}
```