
/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 * 
 * Requires: 1.2.2+
 */
(function(d){function e(a){var b=a||window.event,c=[].slice.call(arguments,1),f=0,e=0,g=0,a=d.event.fix(b);a.type="mousewheel";b.wheelDelta&&(f=b.wheelDelta/120);b.detail&&(f=-b.detail/3);g=f;b.axis!==void 0&&b.axis===b.HORIZONTAL_AXIS&&(g=0,e=-1*f);b.wheelDeltaY!==void 0&&(g=b.wheelDeltaY/120);b.wheelDeltaX!==void 0&&(e=-1*b.wheelDeltaX/120);c.unshift(a,f,e,g);return(d.event.dispatch||d.event.handle).apply(this,c)}var c=["DOMMouseScroll","mousewheel"];if(d.event.fixHooks)for(var h=c.length;h;)d.event.fixHooks[c[--h]]=
    d.event.mouseHooks;d.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=c.length;a;)this.addEventListener(c[--a],e,false);else this.onmousewheel=e},teardown:function(){if(this.removeEventListener)for(var a=c.length;a;)this.removeEventListener(c[--a],e,false);else this.onmousewheel=null}};d.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);

/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.0
 *
 */
(function(f){jQuery.fn.extend({slimScroll:function(h){var a=f.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:0.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:0.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},h);this.each(function(){function r(d){if(s){d=d||
    window.event;var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);f(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&m(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function m(d,f,h){k=!1;var e=d,g=b.outerHeight()-c.outerHeight();f&&(e=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),e=Math.min(Math.max(e,0),g),e=0<d?Math.ceil(e):Math.floor(e),c.css({top:e+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());
    e=l*(b[0].scrollHeight-b.outerHeight());h&&(e=d,d=e/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),g),c.css({top:d+"px"}));b.scrollTop(e);b.trigger("slimscrolling",~~e);v();p()}function C(){window.addEventListener?(this.addEventListener("DOMMouseScroll",r,!1),this.addEventListener("mousewheel",r,!1),this.addEventListener("MozMousePixelScroll",r,!1)):document.attachEvent("onmousewheel",r)}function w(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),D);c.css({height:u+"px"});
    var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function v(){w();clearTimeout(A);l==~~l?(k=a.allowPageScroll,B!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;B=l;u>=b.outerHeight()?k=!0:(c.stop(!0,!0).fadeIn("fast"),a.railVisible&&g.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(A=setTimeout(function(){a.disableFadeOut&&s||(x||y)||(c.fadeOut("slow"),g.fadeOut("slow"))},1E3))}var s,x,y,A,z,u,l,B,D=30,k=!1,b=f(this);if(b.parent().hasClass(a.wrapperClass)){var n=b.scrollTop(),
    c=b.parent().find("."+a.barClass),g=b.parent().find("."+a.railClass);w();if(f.isPlainObject(h)){if("height"in h&&"auto"==h.height){b.parent().css("height","auto");b.css("height","auto");var q=b.parent().parent().height();b.parent().css("height",q);b.css("height",q)}if("scrollTo"in h)n=parseInt(a.scrollTo);else if("scrollBy"in h)n+=parseInt(a.scrollBy);else if("destroy"in h){c.remove();g.remove();b.unwrap();return}m(n,!1,!0)}}else{a.height="auto"==a.height?b.parent().height():a.height;n=f("<div></div>").addClass(a.wrapperClass).css({position:"relative",
    overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var g=f("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=f("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?
    "block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),q="right"==a.position?{right:a.distance}:{left:a.distance};g.css(q);c.css(q);b.wrap(n);b.parent().append(c);b.parent().append(g);a.railDraggable&&c.bind("mousedown",function(a){var b=f(document);y=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);m(0,c.position().top,!1)});
    b.bind("mouseup.slimscroll",function(a){y=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});g.hover(function(){v()},function(){p()});c.hover(function(){x=!0},function(){x=!1});b.hover(function(){s=!0;v();p()},function(){s=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(z=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&
(m((z-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),z=b.originalEvent.touches[0].pageY)});w();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),m(0,!0)):"top"!==a.start&&(m(f(a.start).position().top,null,!0),a.alwaysVisible||c.hide());C()}});return this}});jQuery.fn.extend({slimscroll:jQuery.fn.slimScroll})})(jQuery);
var tf_location_cities_loaded = false;
var speed = 300;
function tfLocationPopupOpen(path, callback) {
    TFLocationOverlay = $('.custom-popup-2014-overlay');
    TFLocationPopup = $('.custom-popup-2014');
    TFLocationOverlay.appendTo('body');
    TFLocationPopup.appendTo('body');
    $('body').children().addClass('tf_location_body_blur');

    TFLocationCallback = callback; TFLoctaionComponentPath = path;
    TFLocationPopupContent = $('.custom-popup-2014-content'); TFLocationCitiesList = TFLocationPopup.find('.popup-city .inner');
    TFLocationCurrentList = TFLocationPopup.find('.current-list'); TFLocationSearch = TFLocationPopup.find('.city-search');
    TFLocationNiceScroll = TFLocationPopup.find(".nice-scroll");
    TFLocationOverlay.fadeIn(speed, function() {
        TFLocationOverlay.removeClass('tf_location_body_blur');
        TFLocationPopup.removeClass('tf_location_body_blur');
        if (!tf_location_cities_loaded) {
            TFLocationPopup.addClass('loading');
            $.get(path+'/functions.php', {request: 'getcities'}, function(data) {
                TFLocationCitiesList.append('<ul class="result-list"></ul>');
                if (data.CITIES) {
                    $.each(data.CITIES, function(key, city) {
                        TFLocationCitiesList.find('ul').append('<li><a data-id="'+city.ID+'" href="#">'+city.NAME+'</a></li>');
                    });
                }
                if (data.DEFAULT_CITIES) {
                    $.each(data.DEFAULT_CITIES, function(key, city) {
                        TFLocationCurrentList.append('<li><a data-id="'+city.ID+'" href="#">'+city.NAME+'</a></li>');
                    });
                } else {
                    TFLocationPopup.find('.popup-city').css('width', 630);
                    TFLocationPopup.find('.result-list').css('width', 630);
                }
                TFLocationPopupContent.fadeIn(function() {
                    $('.custom-popup-2014-content li a').click(function() {
                        $('.tf_location_link span').html($(this).html());
                        selctedCityID = $(this).data('id');
                        selctedCityNAME = $(this).html();
                        $('.tf_location_city_input').val(selctedCityID);
                        $.post(TFLoctaionComponentPath+'/functions.php', {request: 'setcity', city: selctedCityID}, function() {
                            TFLocationOverlay.fadeOut(speed);
                            TFLocationPopup.fadeOut(speed, function() {
                                $('.tf_location_body_blur').removeClass('tf_location_body_blur')
                                if ($.type(TFLocationCallback) == 'function') {
                                    TFLocationCallback(selctedCityID, selctedCityNAME);
                                } else if ($.type(window[TFLocationCallback]) == 'function') {
                                    window[TFLocationCallback](selctedCityID, selctedCityNAME);
                                }
                            });
                        });
                        return false;
                    });
                });
                TFLocationPopup.removeClass('loading');
                TFLocationNiceScroll.slimscroll({
                    size: 10,
                    color: '#aaa',
                    borderRadius: 5,
                    alwaysVisible: false,
                    railColor: '#eee',
                });
            }, 'json');
            TFLocationSearch.keyup(function() {
                TFLocationSearchRequest = $(this).val().toUpperCase();
                if (TFLocationSearchRequest.length > 0) TFLocationPopup.find('.clear_field').fadeIn();
                else TFLocationPopup.find('.clear_field').fadeOut();
                TFLocationCitiesList.find('a').each(function() {
                    var city = $(this).html().toUpperCase();
                    if (city.indexOf(TFLocationSearchRequest) < 0) {
                        $(this).parent().hide();
                    } else {
                        $(this).parent().show();
                    }
                });
                TFLocationNiceScroll.slimscroll();
            });
            TFLocationPopup.find('.clear_field').click(function() {
                $(this).fadeOut();
                TFLocationSearch.val('');
                TFLocationCitiesList.find('li').show();
                TFLocationNiceScroll.slimscroll();
            });
            tf_location_cities_loaded = true;

        }
    });
    TFLocationPopup.fadeIn(speed, function() {
        TFLocationNiceScroll.slimscroll();
    });
    $('.custom-popup-2014-overlay, .custom-popup-2014 .custom-popup-2014-close').on('click', function(){
        TFLocationOverlay.fadeOut(speed);
        TFLocationPopup.fadeOut(speed);
        $('.tf_location_body_blur').removeClass('tf_location_body_blur');
    });
    return false;
}
function TFLocationSelected(cityID, cityNAME) {
    alert(cityID + ': ' + cityNAME);
}