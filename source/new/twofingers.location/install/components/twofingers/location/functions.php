<?
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS",true);

use Bitrix\Main\Web\Json;
use \TwoFingers\Location\Location;
use Bitrix\Main\Application;
use TwoFingers\Location\Settings;
use \TwoFingers\Location\Storage;

require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

if (!CModule::IncludeModule('twofingers.location')
    || ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest'))
{
    require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/epilog_after.php");
    return;
}

$request = Application::getInstance()->getContext()->getRequest();

if ($request->get('request') == 'getcities')
{
    try{
        $defaultCities  = Location::getDefaultList();

        switch (Settings::get('TF_LOCATION_LOAD_LOCATIONS')):
            case 'cities':
                $cities = Location::getCitiesList();
                break;
            case 'defaults':
                $cities = [];
                break;
            default:
                $cities = Location::getList();
        endswitch;

    } catch (\Exception $e) {
        $cities = $defaultCities = [];
    }

    $cities         = Location::markSameNames($cities);
    $defaultCities  = Location::markSameNames($defaultCities);

    $response = [
        'CITIES'            => array_values($cities),
        'DEFAULT_CITIES'    => array_values($defaultCities)
    ];

    print Json::encode($response);
}

if ($request->get('request') == 'setcity')
{
    $locationId = trim($request->get('location_id'));

    if (!strlen($locationId))
        $locationId = trim($request->get('city')); // old style

    if (!strlen($locationId)) return;

    $locationName = trim($request->get('location_name'));
    if (!strlen($locationName))
        $locationName = Location::getNameById($locationId);

    $reload     = Settings::get('TF_LOCATION_RELOAD') == 'Y';
    $redirect   = false;

    if ($locationName)
    {
        Storage::setLocationId($locationId);
        Storage::setLocationName(mb_convert_encoding($locationName, LANG_CHARSET, 'UTF-8'));
        Storage::setRegionId($request->get('region_id') == 'undefined' ? '' : $request->get('region_id'));
        Storage::setRegionName($request->get('region_name') == 'undefined' ? '' : mb_convert_encoding($request->get('region_name'), LANG_CHARSET, 'UTF-8'));
        Storage::setCountryId($request->get('country_id') == 'undefined' ? '' : $request->get('country_id'));
        Storage::setCountryName($request->get('country_name') == 'undefined' ? '' : mb_convert_encoding($request->get('country_name'), LANG_CHARSET, 'UTF-8'));

        //
        if (Settings::get('TF_LOCATION_REDIRECT') != 'N') {
            $domain = \TwoFingers\Location\Iblock\Content::getDomainByLocationId($locationId);
            if (strlen($domain)) {
                $requestUri = $request->get('requestUri');
                if (!strlen($requestUri)) $requestUri = '/';

                $redirect = $domain . $requestUri;
            }
        }
    } else {
        Storage::clear();
    }

    $response = [
        'status' => 'success',
    ];

    if (strlen($redirect)) {
        $response['redirect']   = $redirect;
    } else {
        $response['reload']     = $reload;
    }

    print Json::encode($response);
}

if ($request->get('request') == 'close_confirm_popup') {
    Storage::setConfirmPopupClosedByUser('Y');
    print Json::encode(['status' => 'success']);
}

if ($request->get('request') == 'find')
{
    $result = [];
    $q = $request->get('q');

    if (strlen($q))
    {
        $result = Location::find($q);
        $result = Location::markSameNames($result);
    }

    $response = ['CITIES' => array_values($result)];

    print Json::encode($response);
}

require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/epilog_after.php");