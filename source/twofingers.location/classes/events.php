<?
class TF_LOCATION_Events {
    function setDefaultLocation(&$arResult, &$arUserResult, &$arParams) {
        $settings = TF_LOCATION_Settings::GetSettings();
        if ($settings['TF_LOCATION_TEMPLATE'] == 'Y') {
            $arParams['TEMPLATE_LOCATION'] = 'tf_location';
        }
        if ($settings['TF_LOCATION_DELIVERY'] == 'Y') {
            foreach($arResult['ORDER_PROP']['USER_PROPS_Y'] as $arFind) {
                if ($arFind['TYPE']=='LOCATION') {
                    $arProp = $arFind;
                    $i=$arFind['ID'];
                    break;
                }
            };
            if (!isset($_REQUEST['ORDER_PROP_'.$i])) {
                if(empty($_SESSION['TF_LOCATION_SELECTED_CITY']) || !isset($_SESSION['TF_LOCATION_SELECTED_CITY'])){
                    include_once('SxGeo.php');
                    mb_internal_encoding("cp-1251");
                    $SxGeo = new TF_LOCATION_SxGeo($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/twofingers.location/classes/SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY);
                    $city = $SxGeo->get(TF_LOCATION_Helpers::GetRealIp());
                    mb_internal_encoding(LANG_CHARSET);
                    unset($SxGeo);
                    if($city['city']!=""){
                        $city_name = iconv('UTF-8', LANG_CHARSET, $city['city']);
                        $db_vars = CSaleLocation::GetList(array("CITY_NAME"=>"ASC"), array("LID" => LANGUAGE_ID, 'CITY_NAME'=>$city_name), false, false, array());
                        if($vars = $db_vars->Fetch()) {
                            $_SESSION['TF_LOCATION_SELECTED_CITY'] = $vars['ID'];
                            $_SESSION['TF_LOCATION_SELECTED_CITY_NAME'] = $vars['CITY_NAME'];
                        }
                    }
                }
                $arUserResult['DELIVERY_LOCATION'] = $_SESSION['TF_LOCATION_SELECTED_CITY'];
                $arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VALUE'] = $_SESSION['TF_LOCATION_SELECTED_CITY'];
                foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VARIANTS'] as $key=>$arLocation) {
                    if ($arLocation['SELECTED'] == 'Y') {
                        $arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VARIANTS'][$key]['SELECTED'] = 'N';
                    }
                };
                foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VARIANTS'] as $key=>$arLocation) {
                    if($arLocation['ID']==$_SESSION['TF_LOCATION_SELECTED_CITY']) {
                        $arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VARIANTS'][$key]['SELECTED'] = 'Y';
                        $arResult['ORDER_PROP']['USER_PROPS_Y'][$i]['VALUE'] = $arLocation['ID'];
                    };
                };
            }
        };

    }
}
?>