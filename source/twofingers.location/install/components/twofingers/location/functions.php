<?
require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('twofingers.location');
$settings = TF_LOCATION_Settings::GetSettings();
if ($_REQUEST['request'] == 'getcities') {
    if (CModule::IncludeModule('sale')) {
        $db_vars = CSaleLocation::GetList(array("CITY_NAME_LANG"=>"ASC"), array("LID" => LANGUAGE_ID), false, false, array());
        while ($vars = $db_vars->Fetch()) {
            if ($vars['CITY_ID'] > 0) {
                $cities[] = Array(
                    'NAME' => iconv(LANG_CHARSET, 'UTF-8', $vars['CITY_NAME']),
                    'ID' => $vars['ID']
                );
                if (!CSaleLocation::isLocationProMigrated() && in_array($vars['ID'], $settings['TF_LOCATION_DEFAULT_CITIES'])) {
                    $arr['DEFAULT_CITIES'][] = Array(
                        'NAME' => iconv(LANG_CHARSET, 'UTF-8', $vars['CITY_NAME']),
                        'ID' => $vars['ID']
                    );
                }
            }
        }
        if(method_exists('CSaleLocation','isLocationProMigrated')){
            if(CSaleLocation::isLocationProMigrated()){
                $clas = new Bitrix\Sale\Location\DefaultSiteTable;
                $res = $clas::getList(array(
                        'filter' => array(
                            'SITE_ID' => SITE_ID,
                            'LOCATION.NAME.LANGUAGE_ID' => LANGUAGE_ID
                        ),
                        'order' => array(
                            'SORT' => 'asc'
                        ),
                        'select' => array(
                            'CODE' => 'LOCATION.CODE',
                            'ID' => 'LOCATION.ID',
                            'PARENT_ID' => 'LOCATION.PARENT_ID',
                            'TYPE_ID' => 'LOCATION.TYPE_ID',
                            'LATITUDE' => 'LOCATION.LATITUDE',
                            'LONGITUDE' => 'LOCATION.LONGITUDE',

                            'NAME' => 'LOCATION.NAME.NAME',
                            'SHORT_NAME' => 'LOCATION.NAME.SHORT_NAME',

                            'LEFT_MARGIN' => 'LOCATION.LEFT_MARGIN',
                            'RIGHT_MARGIN' => 'LOCATION.RIGHT_MARGIN'
                        )
                    ));
                $defaults = array();
                while($item = $res->Fetch())
                    $defaults[$item['ID']] = $item;

                foreach($defaults as &$default)
                {
                    unset($default['LEFT_MARGIN']);
                    unset($default['RIGHT_MARGIN']);
                }
                foreach($defaults as $def){
                    $arr['DEFAULT_CITIES'][] = Array(
                        'NAME' => iconv(LANG_CHARSET, 'UTF-8', $def['NAME']),
                        'ID' => $def['ID']
                    );
                }
            }
        }
        $arr['CITIES'] = $cities;
        print json_encode($arr);
    }
}
if ($_REQUEST['request'] == 'setcity') {
    if (CModule::IncludeModule('sale')) {
        $db_vars = CSaleLocation::GetList(array("CITY_NAME_LANG"=>"ASC"), array("LID" => LANGUAGE_ID), false, false, array());
        while ($vars = $db_vars->Fetch()) {
            if ($vars['ID'] == intval($_REQUEST['city'])) {
                $_SESSION['TF_LOCATION_SELECTED_CITY'] = $_REQUEST['city'];
                $_SESSION['TF_LOCATION_SELECTED_CITY_NAME'] = $vars['CITY_NAME'];
            }
        }
    }

}
?>