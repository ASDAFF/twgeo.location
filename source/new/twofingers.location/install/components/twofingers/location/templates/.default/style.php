<style>
    .tfl-popup{
        border-radius:<?=intval($arResult['SETTINGS']['TF_LOCATION_POPUP_RADIUS'])?>px;
    }
    .tfl-define-popup{
        border-radius:<?=intval($arResult['SETTINGS']['TF_LOCATION_CONFIRM_POPUP_RADIUS'])?>px;
    }
    .tfl-define-popup__main{
        color: <?=$arResult['PRIMARY_COLOR']?>;
        background-color: <?=$arResult['PRIMARY_BG']?>;
    }
    .tfl-define-popup__main:hover{
        color: <?=$arResult['PRIMARY_COLOR_HOVER']?>;
        background-color: <?=$arResult['PRIMARY_BG_HOVER']?>;
    }

    .tfl-define-popup__second{
        color: <?=$arResult['SECONDARY_COLOR']?>;
        background-color: <?=$arResult['SECONDARY_BG']?>;
    }
    .tfl-define-popup__second:hover{
        color: <?=$arResult['SECONDARY_COLOR_HOVER']?>;
        background-color: <?=$arResult['SECONDARY_BG_HOVER']?>;
    }

    @media screen and (max-width: <?=$arResult['SETTINGS']['TF_LOCATION_MOBILE_WIDTH']?>px)
    {
        .tfl-popup {
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
        .tfl-popup>div {
            align-self: stretch;
        }
        .tfl-popup.tfl-popup_loading {
            height: 100%;
        }
        .tfl-popup__lists-container{
            height: 100%;
            align-self: stretch;
            flex-direction: column;
            display: flex;
        }

        .tfl-popup__container {
            float: none;
            align-self: stretch;
            height: 100%;
        }

        .tfl-popup__with-defaults .tfl-popup__container.tfl-popup__locations,
        .tfl-popup__with-defaults .tfl-popup__container.tfl-popup__defaults{
            width: 100%;
        }

        .tfl-popup__with-defaults .tfl-popup__defaults{
            margin-bottom: 1rem;
            height: auto;
        }

        .tfl-popup__container,
        .tfl-popup__scroll-container{
            max-height: none;
            min-height: auto;
        }

        .tfl-popup .tfl-popup__search-input {
            max-width: none;
            width: 100%;
        }

        .tfl-popup__list {
            width: 100%;
        }

        /** there is some bug in js with overriding this class */
        /*.slimScrollDiv {
            height: 100%;
        }*/
    }
</style>