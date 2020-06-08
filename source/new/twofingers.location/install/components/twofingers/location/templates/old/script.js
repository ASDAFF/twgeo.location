var tf_location_cities_loaded = false,
    speed = 300;

if( !window.BX && top.BX )
    window.BX = top.BX;

function tfLocationPopupOpen(TFLocationComponentPath, TFLocationCallback)
{
    var $body               = $('body'),
        TFLocationOverlay   = $body.children('.custom-popup-2014-overlay'),
        TFLocationPopup     = $body.children('.custom-popup-2014'),
        TFLocationPopupContent  = $('.custom-popup-2014-content'),
        TFLocationCitiesList, TFLocationCurrentList,
        TFLocationSearch, TFLocationNiceScroll;

    if (!TFLocationOverlay.length){
        TFLocationOverlay = $('.custom-popup-2014-overlay');
        TFLocationOverlay.appendTo('body');
    }

    if (!TFLocationPopup.length) {
        TFLocationPopup     = $('.custom-popup-2014');
        TFLocationPopup.appendTo('body');
    }

    TFLocationCitiesList    = TFLocationPopup.find('.popup-city .inner');
    TFLocationCurrentList   = TFLocationPopup.find('.current-list');
    TFLocationSearch        = TFLocationPopup.find('.city-search');
    TFLocationNiceScroll    = TFLocationPopup.find(".nice-scroll");

    $body.children().addClass('tf_location_body_blur');
    $body.addClass('tf_location_body_freeze');

    TFLocationOverlay.fadeIn(speed, function()
    {
        TFLocationOverlay.removeClass('tf_location_body_blur');
        TFLocationPopup.removeClass('tf_location_body_blur');

        if (tf_location_cities_loaded) return;

        TFLocationPopup.addClass('loading');
        $.get(TFLocationComponentPath + '/functions.php', {request: 'getcities'}, function(data)
        {
            var $locations = $('<ul class="result-list"></ul>');

            if (data.CITIES)
            {
                $.each(data.CITIES, function(key, city)
                {
                    var location;

                    location = '<li><a class="tf-location__link" data-id="' + city.ID
                        + '" data-name="' + city.NAME
                        + '" data-region-name="' + city.REGION_NAME
                        + '" href="#">' + city.NAME + '</a>';

                    if (city.SHOW_REGION == 'Y'){
                        location += '<div class="tf-location__region">' + city.REGION_NAME +'</div>';
                    }

                    location += '</li>';

                    $locations.append(location)
                });
            }

            TFLocationCitiesList.append($locations);

            if (data.DEFAULT_CITIES)
            {
                $.each(data.DEFAULT_CITIES, function(key, city)
                {
                    TFLocationCurrentList.append('<li><a data-id="' + city.ID
                        + '" data-name="' + city.NAME
                        + '" data-region-name="' + city.REGION_NAME + '" href="#">'
                        + city.NAME + '</a></li>');
                });
            } else {
                TFLocationPopup.find('.popup-city').css('width', 630);
                TFLocationPopup.find('.result-list').css('width', 630);
            }

            TFLocationPopupContent.fadeIn(function()
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

                    $('.tf_location_link span').html($(this).html());
                    $('.tf_location_city_input').val(selectedCityID);

                    $body.removeClass('tf_location_body_freeze');

                    $.post(TFLocationComponentPath + '/functions.php', {request: 'setcity', city: selectedCityID}, function()
                    {
                        TFLocationOverlay.fadeOut(speed);
                        TFLocationPopup.fadeOut(speed, function()
                        {
                            $('.tf_location_body_blur').removeClass('tf_location_body_blur');

                            TFLocationCallback = TFLocationCallback.replace('#TF_LOCATION_CITY_ID#', selectedCityID);
                            TFLocationCallback = TFLocationCallback.replace('#TF_LOCATION_CITY_NAME#', selectedCityNAME);

                            try
                            {

                                eval( TFLocationCallback );
                            }
                            catch(e)
                            {
                                return false;
                            }

                            BX.onCustomEvent('onTFLocationSetLocation', [location]);
                        });
                    });
                    return false;
                });
            });
            TFLocationPopup.removeClass('loading');
            TFLocationNiceScroll.slimScroll({
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

        TFLocationSearch.keyup(function()
        {
            var TFLocationSearchRequest = $(this).val().toUpperCase(),
                $locations = TFLocationCitiesList.find('a');

            if (TFLocationSearchRequest.length > 0){
                TFLocationPopup.find('.clear_field').fadeIn();
            } else {
                TFLocationPopup.find('.clear_field').fadeOut();
            }

            if (!$locations.length) return;

            $locations.each(function()
            {
                var city = $(this).html().toUpperCase();

                if (city.indexOf(TFLocationSearchRequest) < 0) {
                    $(this).parent().hide();
                } else {
                    $(this).parent().show();
                }
            });

            TFLocationNiceScroll.slimscroll();
        });

        TFLocationPopup.find('.clear_field').click(function()
        {
            $(this).fadeOut();
            TFLocationSearch.val('');
            TFLocationCitiesList.find('li').show();
            TFLocationNiceScroll.slimscroll();
        });

        tf_location_cities_loaded = true;
    });

    TFLocationPopup.fadeIn(speed, function()
    {
        TFLocationNiceScroll.slimscroll();
    });

    $('.custom-popup-2014-overlay, .custom-popup-2014 .custom-popup-2014-close').on('click', function()
    {
        TFLocationOverlay.fadeOut(speed);
        TFLocationPopup.fadeOut(speed);
        $('.tf_location_body_blur').removeClass('tf_location_body_blur');
        $('body').removeClass('tf_location_body_freeze');
    });

    return false;
}

/*BX.addCustomEvent("onTFLocationSetLocation", function(location)
{
    var $location = $(location);

    console.log('location id: ' + $location.data('id'));
    console.log('location name: ' + $location.data('name'));
    console.log('location region name: ' + $location.data('region-name'));
});*/