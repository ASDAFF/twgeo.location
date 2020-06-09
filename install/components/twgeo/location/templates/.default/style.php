<style>
    .twgl-popup{
        border-radius:<?=intval($arResult['SETTINGS']['TWG_LOCATION_POPUP_RADIUS'])?>px;
    }
    .twgl-define-popup{
        border-radius:<?=intval($arResult['SETTINGS']['TWG_LOCATION_CONFIRM_POPUP_RADIUS'])?>px;
    }
    .twgl-define-popup__main{
        color: <?=$arResult['PRIMARY_COLOR']?>;
        background-color: <?=$arResult['PRIMARY_BG']?>;
    }
    .twgl-define-popup__main:hover{
        color: <?=$arResult['PRIMARY_COLOR_HOVER']?>;
        background-color: <?=$arResult['PRIMARY_BG_HOVER']?>;
    }

    .twgl-define-popup__second{
        color: <?=$arResult['SECONDARY_COLOR']?>;
        background-color: <?=$arResult['SECONDARY_BG']?>;
    }
    .twgl-define-popup__second:hover{
        color: <?=$arResult['SECONDARY_COLOR_HOVER']?>;
        background-color: <?=$arResult['SECONDARY_BG_HOVER']?>;
    }

    @media screen and (max-width: <?=$arResult['SETTINGS']['TWG_LOCATION_MOBILE_WIDTH']?>px)
    {
        .twgl-popup {
            width: 100%;
            height: 100%;
            top: 50%;
            display: flex;
            align-items: flex-start;
            /*flex-wrap: wrap;*/
            flex-direction: column;
            border-radius: 0;
            z-index: 9999999;
        }
        .twgl-popup>div {
            align-self: stretch;
        }
        .twgl-popup.twgl-popup_loading {
            height: 100%;
        }
        .twgl-popup__lists-container{
            height: 100%;
            align-self: stretch;
            flex-direction: column;
            display: flex;
        }

        .twgl-popup__container {
            float: none;
            align-self: stretch;
            height: 100%;
        }

        .twgl-popup__with-defaults .twgl-popup__container.twgl-popup__locations,
        .twgl-popup__with-defaults .twgl-popup__container.twgl-popup__defaults{
            width: 100%;
        }

        .twgl-popup__with-defaults .twgl-popup__defaults{
            margin-bottom: 1rem;
            height: auto;
        }

        .twgl-popup__container,
        .twgl-popup__scroll-container{
            max-height: none;
            min-height: auto;
        }

        .twgl-popup .twgl-popup__search-input {
            max-width: none;
            width: 100%;
        }

        .twgl-popup__list {
            width: 100%;
        }

        /** there is some bug in js with overriding this class */
        /*.slimScrollDiv {
            height: 100%;
        }*/
    }
</style>