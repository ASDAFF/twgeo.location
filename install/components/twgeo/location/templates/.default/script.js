/*
 * Copyright (c) 9/6/2020 Created By/Edited By ASDAFF asdaff.asad@yandex.ru
 */

var twg_location_cities_loaded = false,
    twg_location_animation_speed = 300;

if( !window.BX && top.BX )
    window.BX = top.BX;

function TwGLocation(params, callback) {

    var self = this;

    this.params         = params;
    this.callback       = callback;
    this.$body          = $('body');
    this.$bodyChildren  = this.$body.children();
    this.mobileWidth    = !!this.params.mobile_width ? parseInt(this.params.mobile_width) : 0;

    this.LocationsPopup = new TwGLocationsPopup(this);
    this.ConfirmPopup   = new TfConfirmPopup(this);

    this.openLocationsPopup = function ($link) {
        this.LocationsPopup.open($link);
        this.ConfirmPopup.close();
    };

    this.openConfirmPopup = function () {
        this.ConfirmPopup.open();
        this.LocationsPopup.close();
    };

    /**
     *
     * @returns {boolean}
     */
    this.isMobile = function()
    {
        return (window.innerWidth <= this.mobileWidth);
    };

    this.htmlspecialchars = function(str) {
        if (typeof(str) == "string") {
            str = str.replace(/&/g, '&amp;'); /* must do &amp; first */
            str = str.replace(/"/g, '&quot;');
            str = str.replace(/'/g, '&#039;');
            str = str.replace(/</g, '&lt;');
            str = str.replace(/>/g, '&gt;');
        }
        return str;
    };

    this.htmlspecialcharsDecode = function(str) {
        if (typeof(str) == "string") {
            str = str.replace(/&quot;/g, '"');
            str = str.replace(/&#039;/g, '\'');
            str = str.replace(/&lt;/g, '<');
            str = str.replace(/&gt;/g, '>');
            str = str.replace(/&amp;/g, '&'); /* must do &amp; first */

        }
        return str;
    };

    this.removeTags = function (str) {
        if (typeof(str) == "string") {
            str = str.replace(/<[^>]+>/g,'');
        }
        return str;
    };

    this.clearStr = function (str)
    {
        if (typeof(str) == "string") {
            str = this.htmlspecialcharsDecode(str);
            str = this.removeTags(str);
        }
        return str;
    }
}
/**
 *
 * @param TwGLocation
 * @constructor
 */
function TwGLocationsPopup(TwGLocation)
{
    var self = this;

    this.TwGLocation         = TwGLocation;
    this.callback           = TwGLocation.callback;
    this.$body              = TwGLocation.$body;
    this.$bodyChildren      = TwGLocation.$bodyChildren;
    this.$overlay           = this.$body.find('.twgl-popup-overlay');
    this.$popup             = this.$body.find('.twgl-popup');

    if (this.$overlay.length){
        if (this.$overlay.length > 1) {
            this.$overlay.first().remove();
        } else {
            this.$overlay.appendTo(this.$body);
        }
    }

    this.componentPath          = !!this.TwGLocation.params.path ? this.TwGLocation.params.path : '';
    this.requestUri             = !!this.TwGLocation.params.request_uri ? this.TwGLocation.params.request_uri : '/';
    this.$locationsContainer    = this.$popup.find(".twgl-popup__locations");
    this.$defaultsContainer     = this.$popup.find(".twgl-popup__defaults");
    this.Search                 = new TwGLocationsPopupSearch(this);
    this.isOrderPage            = false;

    this.open = function ($link)
    {
        if (!!$link && $link.length && $link.data('order')) {
            this.isOrderPage = true;

            if (typeof BX != 'undefined' && !!BX.Sale.OrderAjaxComponent) {
                this.callback += '; BX.Sale.OrderAjaxComponent.sendRequest();';
            }
        }

        this.$overlay.fadeIn({
            duration: twg_location_animation_speed,
            start: this.onOpenStart,
            complete: this.onOpenComplete
        });
    };

    this.onOpenStart = function () {
        self.$bodyChildren.addClass('twgl-body-blur');
        self.$body.addClass('twgl-body-freeze');

        if (!twg_location_cities_loaded){
            self.loadLocations();
            self.Search.init();
            self.initClose();
            twg_location_cities_loaded = true;
        }
    };

    this.onOpenComplete = function () {
        self.$overlay.removeClass('twgl-body-blur');
        self.$popup.removeClass('twgl-body-blur');
    };

    this.loadLocations = function()
    {
        this.$popup.addClass('twgl-popup_loading');

        $.get(this.componentPath + '/functions.php', {request: 'getcities'}, function(data)
        {
            if (data.CITIES.length)
            {
                self.addLocations(self.$locationsContainer, data.CITIES, 'twgl-popup__with-locations');
            }

            if (data.DEFAULT_CITIES.length)
            {
                self.addLocations(self.$defaultsContainer, data.DEFAULT_CITIES, 'twgl-popup__with-defaults');
            }

            self.addLocationsHandler(self.$popup.find('.twgl-popup__location-link'));

            self.$popup.removeClass('twgl-popup_loading');
            self.checkLocationsHeight();

            $(window).on('resize', self.checkLocationsHeight);

        }, 'json');
    };

    this.checkLocationsHeight = function () {
        if (!self.TwGLocation.isMobile()) {
            self.$locationsContainer.css('height', 'inherit');
            return;
        }

        var delta = Math.round((self.$popup.innerHeight() - self.$popup.height()) / 2),
            maxHeight = self.$popup.height() - self.$locationsContainer.position().top + delta;

        if (self.$locationsContainer.height() > maxHeight)
        {
            self.$locationsContainer.height(maxHeight);
        } else {
            self.$locationsContainer.css('height', 'inherit');
        }
    };

    /**
     *
     * @param $container
     * @param locations
     * @param popupClass
     * @param source
     * @returns {{length}|*}
     */
    this.addLocations = function($container, locations, popupClass, source)
    {
        var $list   = $container.find('.twgl-popup__list'),
            $scroll = $container.find('.twgl-popup__scroll-container');

        if (!$list.length) {
            return;
        }

        $.each(locations, function(key, location)
        {
            var item = '<li><a class="twgl-popup__location-link" '
                + 'data-id="' + location.ID
                + '" data-name="' + self.TwGLocation.clearStr(location.NAME)
                + '" data-region-name="' + self.TwGLocation.clearStr(location.REGION_NAME)
                + '" data-region-id="' + location.REGION_ID
                + '" data-country-id="' + location.COUNTRY_ID
                + '" data-country-name="' + self.TwGLocation.clearStr(location.COUNTRY_NAME);

            if (!!source) {
                item += '" data-source="' + source;
            } else {
                item += '" data-source="base';
            }

            item += '" href="#">' + self.TwGLocation.htmlspecialcharsDecode(location.NAME) + '</a>';

            if (location.SHOW_REGION === 'Y'){
                item += '<div class="twg-location__region">' + location.REGION_NAME +'</div>';
            }

            item += '</li>';

            $list.append(item)
        });

        if ($scroll.length) {
            /*$scroll.slimscroll({
                height: '100%',
                allowPageScroll: true,
                touchScrollStep: 100,
                wheelStep: 10
            });
            */
            $scroll.niceScroll({
                /*scrollspeed: 500,*/
                mousescrollstep: 50,
                hwacceleration: true,
                bouncescroll: true,
                zindex: "50",
                cursorborderradius: "0px",
                cursorborder: "none",
                horizrailenabled: false,
                cursorcolor: '#666',
                cursorwidth: '5px',
                background:"#d5d5d5",
                autohidemode:'leave',
                cursoropacitymin:0.4,
            });
        }

        if (!!popupClass && popupClass.length) {
            this.$popup.addClass(popupClass);
        }

        return $list;
    };

    /**
     *
     */
    this.initClose = function()
    {
        self.$overlay.on('click', function (e) {
            if (!self.$popup.is(e.target)
                && self.$popup.has(e.target).length === 0) {
                self.close();
            }
        });

        this.$popup.find('.twgl-popup__close-container').on('click', this.close);
    };

    /**
     *
     */
    this.close = function()
    {
        self.$overlay.fadeOut(twg_location_animation_speed);
        self.$bodyChildren.removeClass('twgl-body-blur');
        self.$body.removeClass('twgl-body-freeze');

        return false;
    };

    /**
     *
     * @param $elements
     */
    this.addLocationsHandler = function($elements)
    {
        if (!$elements.length) {
            return;
        }

        $elements.on('click', function(e)
        {
            e.stopPropagation();
            e.preventDefault();

            var location            = this,
                selectedCityID      = $(location).data('id'),
                selectedCityNAME    = $(location).text(),
                $orderLocation      = self.$body.find('.twgl__link.twgl__link_order'),
                $route              = self.$body.find('.bx-ui-sls-route'),
                $saleLocationInput  = self.$body.find('.twg_location_city_input')/*,
                $fake               = $('.bx-ui-sls-fake')*/;

            if ($orderLocation.length && $route.length) {
                $route.val(selectedCityNAME);
            }

            /* if ($fake.length) {
                 $fake.val(selectedCityID);
             }*/

            $('.twgl__link')
                .html(selectedCityNAME)
                .data('location-id', selectedCityID)
                .data('region-id', $(location).data('region-id'))
                .data('country-id', $(location).data('country-id'));

            if ($saleLocationInput.length)
                $saleLocationInput.val(selectedCityID);

            $.post(self.componentPath + '/functions.php', {
                request         : 'setcity',
                requestUri      : self.requestUri,
                location_id     : selectedCityID,
                location_name   : selectedCityNAME,
                region_id       : $(location).data('region-id'),
                region_name     : $(location).data('region-name'),
                country_id      : $(location).data('country-id'),
                country_name    : $(location).data('country-name')
            }, function(response)
            {
                var actualCallBackHandler = self.callback;

                if (typeof BX != 'undefined' && !!BX) {
                    BX.onCustomEvent('onTWGLocationSetLocation', [location]);
                }

                try {
                    actualCallBackHandler = actualCallBackHandler.replace('#TWG_LOCATION_CITY_ID#', selectedCityID);
                    actualCallBackHandler = actualCallBackHandler.replace('#TWG_LOCATION_CITY_NAME#', selectedCityNAME);

                    eval( actualCallBackHandler );
                } catch(e) {
                    console.error('twgeo.location callback error:', e);
                }

                if (!!response.redirect && response.redirect.length && !self.isOrderPage) {
                    window.location.href = response.redirect;
                } else if (!!response.reload && response.reload && !self.isOrderPage) {
                    window.location.reload();
                } else {
                    self.close();
                }
            }, 'json');
        });
    }
}

/**
 *
 * @param LocationsPopup
 * @constructor
 */
function TwGLocationsPopupSearch(LocationsPopup) {

    var self = this;
    this.LocationsPopup = LocationsPopup;
    this.$clear         = LocationsPopup.$popup.find('.twgl-popup__clear-field');
    this.$searchInput   = LocationsPopup.$popup.find('.twgl-popup__search-input');
    this.$list          = LocationsPopup.$locationsContainer.find('.twgl-popup__list');
    this.$noFound       = LocationsPopup.$locationsContainer.find('.twgl-popup__nofound-mess');

    this.init = function () {

        this.initSearch();

        if (this.$clear.length) {
            this.$clear.click(function()
            {
                self.reset();
            });
        }
    };

    this.showClear = function () {
        if (this.$clear.length) {
            this.$clear.fadeIn(twg_location_animation_speed);
        }
    };

    this.hideClear = function () {
        if (this.$clear.length) {
            this.$clear.fadeOut(twg_location_animation_speed);
        }
    };

    this.showNoFoundAndDefaults = function () {
        if (this.$noFound.length) {
            this.$noFound.addClass('twgl-popup__nofound-mess-show');
        }

        this.tryToShowDefaults();
    };

    this.hideNoFound = function () {
        if (this.$noFound.length) {
            this.$noFound.removeClass('twgl-popup__nofound-mess-show');
        }
    };

    this.initSearch = function()
    {
        var delay = 400, timeOutId;

        this.$searchInput.keyup(function()
        {
            var q = $(this).val().toUpperCase();

            if (timeOutId) {
                clearTimeout(timeOutId);
            }

            if (!q.length){
                self.reset();
                return;
            }

            self.showClear();

            timeOutId = setTimeout(function () {

                self.removeResults();
                self.hideNoFound();
                self.$list.find('.twgl-popup__location-link').parent().hide();

                self.LocationsPopup.$popup
                    .addClass('twgl-popup__with-locations')
                    .addClass('twgl-popup_loading');

                self.search(q).done(function (data) {
                    self.updateResults(data.CITIES);
                    self.LocationsPopup.$popup.removeClass('twgl-popup_loading');
                });
            }, delay);
        });
    };

    this.search = function (q) {
        if (!!this.LocationsPopup.TwGLocation.params.ajax_search
            && this.LocationsPopup.componentPath.length)
        {
            return this.ajaxSearch(q);
        } else {
            return this.localSearch(q);
        }
    };

    this.updateResults = function (cities)
    {
        if (!!cities && cities.length)
        {
            self.hideNoFound();
            self.hideDefaults();

            self.LocationsPopup.addLocations(self.LocationsPopup.$locationsContainer, cities, 'twgl-popup__with-locations', 'search');
            self.LocationsPopup.addLocationsHandler(self.$list.find('.twgl-popup__location-link'));
        } else {
            self.showNoFoundAndDefaults();
        }
    };

    this.ajaxSearch = function(q)
    {
        return $.ajax({
            type: "POST",
            url: self.LocationsPopup.componentPath + '/functions.php',
            data: {request: 'find', q: q},
            dataType: 'json'
        });
    };

    this.localSearch = function(q)
    {
        var result = $.Deferred(),
            data = {CITIES: [], FCITIES: []};

        self.$list.find('a[data-source=base]').each(function()
        {
            var city = $(this).html().toUpperCase(),
                name, location;

            if (city.indexOf(q) >= 0) {

                name = $(this).html();
                name = name.substring(0, city.indexOf(q))
                    + '<b>' + name.substring(city.indexOf(q), city.indexOf(q) + q.length)
                    + '</b>' + name.substring(city.indexOf(q) + q.length);
                //console.log(city);
                location = {
                    NAME: name,
                    ID: $(this).data('id'),
                    CODE: $(this).data('code'),
                    REGION_ID: $(this).data('region-id'),
                    REGION_NAME: $(this).data('region-name'),
                    COUNTRY_ID: $(this).data('country-id'),
                    COUNTRY_NAME: $(this).data('country-name'),
                };
                //console.log(location);
                /*if (city.indexOf(q) === 0) {
                    data.CITIES.unshift(location);
                } else {*/
                data.CITIES.push(location);
               /* }*/
            }
        });

        return result.resolve(data);
    };

    this.hideDefaults = function() {
        this.LocationsPopup.$popup.removeClass('twgl-popup__with-defaults');
    };

    this.tryToShowDefaults = function() {
        if (this.LocationsPopup.$defaultsContainer.find('.twgl-popup__location-link').length){
            this.LocationsPopup.$popup.addClass('twgl-popup__with-defaults');
        }
    };

    /**
     *
     */
    this.removeResults = function () {
        this.$list.find('.twgl-popup__location-link[data-source=search]').parent().remove();
    };

    this.reset = function()
    {
        if (self.$searchInput.val.length) {
            self.$searchInput.val('');
        }

        this.hideClear();
        this.hideNoFound();
        this.removeResults();

        var $oldLinks = this.$list.find('.twgl-popup__location-link').parent();
        if ($oldLinks.length) {
            $oldLinks.show();
        } else {
            this.LocationsPopup.$popup.removeClass('twgl-popup__with-locations');
        }

        this.tryToShowDefaults();
    }
}

function TfConfirmPopup(TwGLocation) {

    var self = this;

    this.TwGLocation     = TwGLocation;
    this.params         = TwGLocation.params;
    this.$body          = TwGLocation.$body;
    this.$bodyChildren  = TwGLocation.$bodyChildren;
    this.$popup         = this.$body.find('.twgl-define-popup').first();
    this.componentPath  = !!this.TwGLocation.params.path ? this.TwGLocation.params.path : '';

    if (this.$popup.length) {
        //this.$popup = $('.twgl-define-popup');

        if (this.$popup.length > 1) {
            this.$popup.first().remove();
        } else {
            this.$popup.prependTo(this.$body);
        }
    }

    this.close = function () {
        self.$popup
            .fadeOut(twg_location_animation_speed)
            .data('closed', true);

        if (self.componentPath.length) {
            $.post(self.componentPath + '/functions.php', {request: 'close_confirm_popup'});
        }

        return false;
    };

    this.open = function()
    {
        var $close, $confirm, $list;

        if (!this.$popup.length) return;

        this.setPosition();

        $(window).on('resize scroll', function () {
            self.setPosition();
        });

        //if ($popup.is(':visible')) return;

        $close      = this.$popup.find('.twgl-popup__close-container');
        $confirm    = this.$popup.find('.twgl-define-popup__yes');
        $list       = this.$popup.find('.twgl-define-popup__list');

        this.$popup.fadeIn(twg_location_animation_speed);

        $close.on('click', this.close);
        $confirm.on('click', this.close);
        $list.on('click', function(e){
            self.TwGLocation.openLocationsPopup();
            e.preventDefault();
            e.stopPropagation();
        });
    };


    this.setPosition = function()
    {
        if (this.$popup.data('closed')) return;

        var $link = $('.twgl__link:visible').not('.twgl__link_order').first(),
            left;

        if (this.TwGLocation.isMobile()) {

            this.$popup
                .removeClass('twgl-define-popup__desktop')
                .addClass('twgl-define-popup__mobile')
                .css('top', 'auto')
                .css('left', 'auto')
                .show()
            ;
        } else {
            this.$popup
                .removeClass('twgl-define-popup__mobile')
                .addClass('twgl-define-popup__desktop');

            if ($link.length && ($link.offset().left + $link.width() >= 0))
            {
                left = ($link.offset().left + ($link.width() / 2));

                if (left > ($(window).width() - this.$popup.width() / 2)) {
                    left = ($(window).width() - this.$popup.width() / 2);
                }

                if (left < (this.$popup.width() / 2)) {
                    left = (this.$popup.width() / 2);
                }

                this.$popup
                    .css('left', left + 'px')
                    .css('top', $link.offset().top + $link.outerHeight() + 12)
                    .show();
            } else {
                this.$popup.hide();
            }
        }
    }
}
