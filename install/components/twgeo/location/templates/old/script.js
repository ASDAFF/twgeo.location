/*
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

var twg_location_cities_loaded = false,
    speed = 300;

if( !window.BX && top.BX )
    window.BX = top.BX;

function twgLocationPopupOpen(TWGLocationComponentPath, TWGLocationCallback)
{
    var $body               = $('body'),
        TWGLocationOverlay   = $body.children('.custom-popup-2014-overlay'),
        TWGLocationPopup     = $body.children('.custom-popup-2014'),
        TWGLocationPopupContent  = $('.custom-popup-2014-content'),
        TWGLocationCitiesList, TWGLocationCurrentList,
        TWGLocationSearch, TWGLocationNiceScroll;

    if (!TWGLocationOverlay.length){
        TWGLocationOverlay = $('.custom-popup-2014-overlay');
        TWGLocationOverlay.appendTo('body');
    }

    if (!TWGLocationPopup.length) {
        TWGLocationPopup     = $('.custom-popup-2014');
        TWGLocationPopup.appendTo('body');
    }

    TWGLocationCitiesList    = TWGLocationPopup.find('.popup-city .inner');
    TWGLocationCurrentList   = TWGLocationPopup.find('.current-list');
    TWGLocationSearch        = TWGLocationPopup.find('.city-search');
    TWGLocationNiceScroll    = TWGLocationPopup.find(".nice-scroll");

    $body.children().addClass('twg_location_body_blur');
    $body.addClass('twg_location_body_freeze');

    TWGLocationOverlay.fadeIn(speed, function()
    {
        TWGLocationOverlay.removeClass('twg_location_body_blur');
        TWGLocationPopup.removeClass('twg_location_body_blur');

        if (twg_location_cities_loaded) return;

        TWGLocationPopup.addClass('loading');
        $.get(TWGLocationComponentPath + '/functions.php', {request: 'getcities'}, function(data)
        {
            var $locations = $('<ul class="result-list"></ul>');

            if (data.CITIES)
            {
                $.each(data.CITIES, function(key, city)
                {
                    var location;

                    location = '<li><a class="twg-location__link" data-id="' + city.ID
                        + '" data-name="' + city.NAME
                        + '" data-region-name="' + city.REGION_NAME
                        + '" href="#">' + city.NAME + '</a>';

                    if (city.SHOW_REGION == 'Y'){
                        location += '<div class="twg-location__region">' + city.REGION_NAME +'</div>';
                    }

                    location += '</li>';

                    $locations.append(location)
                });
            }

            TWGLocationCitiesList.append($locations);

            if (data.DEFAULT_CITIES)
            {
                $.each(data.DEFAULT_CITIES, function(key, city)
                {
                    TWGLocationCurrentList.append('<li><a data-id="' + city.ID
                        + '" data-name="' + city.NAME
                        + '" data-region-name="' + city.REGION_NAME + '" href="#">'
                        + city.NAME + '</a></li>');
                });
            } else {
                TWGLocationPopup.find('.popup-city').css('width', 630);
                TWGLocationPopup.find('.result-list').css('width', 630);
            }

            TWGLocationPopupContent.fadeIn(function()
            {
                $('.custom-popup-2014-content li a').on('click', function()
                {
                    var location            = this,
                        selectedCityID      = $(this).data('id'),
                        selectedCityNAME    = $(this).html(),
                        $route              = $('.bx-ui-sls-route')/*,
                        $fake               = $('.bx-ui-sls-fake')*/;

                    if ($route.length) {
                        $route.val(selectedCityNAME);
                    }

                    /* if ($fake.length) {
                         $fake.val(selectedCityID);
                     }*/

                    $('.twg_location_link span').html($(this).html());
                    $('.twg_location_city_input').val(selectedCityID);

                    $body.removeClass('twg_location_body_freeze');

                    $.post(TWGLocationComponentPath + '/functions.php', {request: 'setcity', city: selectedCityID}, function()
                    {
                        TWGLocationOverlay.fadeOut(speed);
                        TWGLocationPopup.fadeOut(speed, function()
                        {
                            $('.twg_location_body_blur').removeClass('twg_location_body_blur');

                            TWGLocationCallback = TWGLocationCallback.replace('#TWG_LOCATION_CITY_ID#', selectedCityID);
                            TWGLocationCallback = TWGLocationCallback.replace('#TWG_LOCATION_CITY_NAME#', selectedCityNAME);

                            try
                            {

                                eval( TWGLocationCallback );
                            }
                            catch(e)
                            {
                                return false;
                            }

                            BX.onCustomEvent('onTWGLocationSetLocation', [location]);
                        });
                    });
                    return false;
                });
            });
            TWGLocationPopup.removeClass('loading');
            TWGLocationNiceScroll.slimScroll({
                size: '10px',
                color: '#aaa',
                borderRadius: 5,
                alwaysVisible: true,
                railColor: '#f5f5f5',
                railVisible: true,
                allowPageScroll: false,
                disableFadeOut: true
            });
        }, 'json');

        TWGLocationSearch.keyup(function()
        {
            var TWGLocationSearchRequest = $(this).val().toUpperCase(),
                $locations = TWGLocationCitiesList.find('a');

            if (TWGLocationSearchRequest.length > 0){
                TWGLocationPopup.find('.clear_field').fadeIn();
            } else {
                TWGLocationPopup.find('.clear_field').fadeOut();
            }

            if (!$locations.length) return;

            $locations.each(function()
            {
                var city = $(this).html().toUpperCase();

                if (city.indexOf(TWGLocationSearchRequest) < 0) {
                    $(this).parent().hide();
                } else {
                    $(this).parent().show();
                }
            });

            TWGLocationNiceScroll.slimscroll();
        });

        TWGLocationPopup.find('.clear_field').click(function()
        {
            $(this).fadeOut();
            TWGLocationSearch.val('');
            TWGLocationCitiesList.find('li').show();
            TWGLocationNiceScroll.slimscroll();
        });

        twg_location_cities_loaded = true;
    });

    TWGLocationPopup.fadeIn(speed, function()
    {
        TWGLocationNiceScroll.slimscroll();
    });

    $('.custom-popup-2014-overlay, .custom-popup-2014 .custom-popup-2014-close').on('click', function()
    {
        TWGLocationOverlay.fadeOut(speed);
        TWGLocationPopup.fadeOut(speed);
        $('.twg_location_body_blur').removeClass('twg_location_body_blur');
        $('body').removeClass('twg_location_body_freeze');
    });

    return false;
}

/*BX.addCustomEvent("onTWGLocationSetLocation", function(location)
{
    var $location = $(location);

    console.log('location id: ' + $location.data('id'));
    console.log('location name: ' + $location.data('name'));
    console.log('location region name: ' + $location.data('region-name'));
});*/