<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 07.03.2019
 * Time: 14:09
 *
 *
 */

namespace TwoFingers\Location;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Request;
use Bitrix\Main\SystemException;
use \TwoFingers\Location\Iblock;
use TwoFingers\Location\Iblock\Content;


/**
 * Class Event
 *
 * @package TwoFingers\Location
 *
 */
class Event
{
    protected static $zipPropId;
    protected static $zipPropValue;

    /**
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws SystemException
     */
    public static function onBeforeProlog()
    {
        if (Storage::isEmpty())
        {
            Storage::setFromCurrent(Current::getInstance());
        } else {
            Storage::setNeedCheck('N');
        }

        if (!Storage::isEmpty())
        {
            $locationId = Storage::getLocationId();

            if (empty(Storage::getLocationName()))
                Storage::setLocationName(Location::getNameById($locationId));

            if (empty(Storage::getLocationName()))
                Storage::clear();
        }

        if (Storage::isEmpty())
        {
            $defaultLocation = Location::getDefault();
            if ($defaultLocation) {
                Storage::setLocationId($defaultLocation['CODE']);
                Storage::setLocationName($defaultLocation['NAME']);
                Storage::setRegionId($defaultLocation['REGION_ID']);
                Storage::setRegionName($defaultLocation['REGION_NAME']);
                Storage::setCountryId($defaultLocation['COUNTRY_ID']);
                Storage::setCountryName($defaultLocation['COUNTRY_NAME']);
                Storage::setNeedCheck('Y');
            }
        }

        $event = new \Bitrix\Main\Event("twofingers.location", "afterLocationDetect");
        $event->send();

        // redirect if needed
        if (!Storage::isEmpty() && (Settings::get('TF_LOCATION_REDIRECT') == 'C'))
        {
            $domain = Content::getDomainByLocationId(Storage::getLocationId());

            if ($domain) {
                $resultDomain = $domain;
                if (strpos($domain, '://'))
                    $domain = substr($domain, strpos($domain, '://') + 3);

                if (strpos($_SERVER['HTTP_HOST'], $domain) !== 0) {
                    header('Location: ' . $resultDomain . $_SERVER['REQUEST_URI'], true, 301);
                    die();
                }
            }
        }
    }

    /**
     * @param $fields
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    public static function onAfterIBlockElementUpdate($fields)
    {
        if (Iblock\Location::getId() != $fields['IBLOCK_ID'])
            return;

        $defaultProperty = Iblock\Location::getPropertyByCode(Iblock\Location::PROPERTY_DEFAULT);
        if (!isset($fields['PROPERTY_VALUES'][$defaultProperty['ID']]))
            return;

        // try to find another default locations
        $filter =[
            'IBLOCK_ID' => Iblock\Location::getId(),
            '!ID'       => $fields['ID'],
            '!PROPERTY_' . Iblock\Location::PROPERTY_DEFAULT => false
        ];

        $elements = \CIBlockElement::GetList([], $filter, false, false, ['ID', 'IBLOCK_ID']);
        while ($element = $elements->Fetch())
            \CIBlockElement::SetPropertyValuesEx($element['ID'], $element['IBLOCK_ID'], [Iblock\Location::PROPERTY_DEFAULT => false]);
    }

    /**
     * @param $arResult
     * @return null
     *
     */
    protected static function getCheckedPersonTypeId($arResult)
    {
        $checkedPersonTypeId = null;
        foreach ($arResult['PERSON_TYPE'] as $personType)
            if (!empty($personType['CHECKED']) && ($personType['CHECKED'] == 'Y'))
                return $personType['ID'];

        return null;
    }

    /**
     * @param $arResult
     * @param $arUserResult
     * @param $arParams
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws SystemException
     *
     */
    public static function setSaleLocationOld(&$arResult, &$arUserResult, $arParams)
    {
        $request = Application::getInstance()->getContext()->getRequest();

        self::setSaleLocation($arUserResult, $request, $arParams, $arResult);
        self::setZip(null, $arUserResult, $request, $arParams, $arResult);
    }

    /**
     * @param         $arUserResult
     * @param Request $request
     * @param         $arParams
     * @param         $arResult
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws SystemException
     *
     */
    public static function setSaleLocation( &$arUserResult, Request $request, &$arParams, &$arResult)
    {
        $settings = Settings::getList();

        if ($settings['TF_LOCATION_DELIVERY'] != 'Y')
            return;

        $checkedPersonTypeId = self::getCheckedPersonTypeId($arResult);
        if (!$checkedPersonTypeId)
            return;

        if ($settings['TF_LOCATION_TEMPLATE'] == 'Y')
            $arParams['TEMPLATE_LOCATION'] = 'tf_location';

        $order              = \Bitrix\Sale\Order::create(\Bitrix\Main\Application::getInstance()->getContext()->getSite());
        $propertyCollection = $order->getPropertyCollection();
        $locationPropertyId = null;
        $zipPropertyId      = null;

        foreach ($propertyCollection as $property)
        {
            /*if ($property->isUtil())
                continue;*/

            $arProperty = $property->getProperty();

            if ($arProperty['UTIL'] == 'Y') continue;

            if(
                (($arProperty['TYPE'] === 'LOCATION')
                    || ($arProperty['IS_ZIP'] === 'Y'))
                && ($arProperty['PERSON_TYPE_ID'] == $checkedPersonTypeId)
                && array_key_exists($arProperty['ID'],$arUserResult["ORDER_PROP"])
                && !$request->getPost("ORDER_PROP_".$arProperty['ID'])
                && (
                    !is_array($arOrder=$request->getPost("order"))
                    || !$arOrder["ORDER_PROP_".$arProperty['ID']]
                )
            ) {
                if ($arProperty['TYPE'] === 'LOCATION')
                    $locationPropertyId = $arProperty['ID'];
                else
                    $zipPropertyId  = $arProperty['ID'];
            }
        }

        if (!$locationPropertyId)
            return;

        if(Storage::isEmpty())
            Storage::setFromCurrent(Current::getInstance());

        if (!Storage::isEmpty())
        {
            $arUserResult['DELIVERY_LOCATION']                  = Storage::getLocationId();
            $arUserResult['DELIVERY_LOCATION_BCODE']            = Storage::getLocationId();
            $arUserResult['ORDER_PROP'][$locationPropertyId]    = Storage::getLocationId();

            if (($settings['TF_LOCATION_DELIVERY_ZIP'] == 'Y') && $zipPropertyId) {

                $zip = Location::getZipById(Storage::getLocationId());
                if (is_array($zip))
                    $zip = reset($zip);

                if (!empty($zip)) {
                    self::$zipPropId = $zipPropertyId;
                    self::$zipPropValue = $zip;

                    $arUserResult['ORDER_PROP'][$zipPropertyId] = $zip;
                    $arUserResult['DELIVERY_LOCATION_ZIP']      = $zip;
                }


                //  $arResult['ORDER_PROP']['USER_PROPS_Y'][$zipPropertyId]['VALUE']    = $zip;
                //  $arResult['ORDER_DATA']['ORDER_PROP'][$zipPropertyId]               = $zip;

            }


            /* $arResult['ORDER_PROP']['USER_PROPS_Y'][$locationPropertyId]['VALUE']
                 = SessionStorage::getLocationId();

             $arResult['ORDER_DATA']['ORDER_PROP'][$locationPropertyId]  = SessionStorage::getLocationId();
             $arResult['ORDER_DATA']['DELIVERY_LOCATION']                = SessionStorage::getLocationId();
             $arResult['ORDER_DATA']['DELIVERY_LOCATION_BCODE']          = SessionStorage::getLocationId();

             if (isset($arResult['LOCATIONS'][$locationPropertyId]['lastValue']))
                 $arResult['LOCATIONS'][$locationPropertyId]['lastValue'] = SessionStorage::getLocationId();
 */

            /*$arResult['USER_VALS']['ORDER_PROP'][$locationPropertyId]  = SessionStorage::getLocationId();
          //  $arResult['ORDER_DATA']['DELIVERY_LOCATION']                = SessionStorage::getLocationId();
            $arResult['USER_VALS']['DELIVERY_LOCATION_BCODE']          = SessionStorage::getLocationId();

            foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as &$property){

                if ($property['ID'] == $locationPropertyId)
                    $property['VALUE'] = [SessionStorage::getLocationId()];
            }

            foreach($arResult['ORDER_PROP']['USER_PROPS_Y'][$locationPropertyId]['VARIANTS'] as $key => $arLocation) {
                if ($arLocation['SELECTED'] == 'Y')
                    $arResult['ORDER_PROP']['USER_PROPS_Y'][$locationPropertyId]['VARIANTS'][$key]['SELECTED'] = 'N';

                if($arLocation['ID'] == SessionStorage::getLocationId()) {
                    $arResult['ORDER_PROP']['USER_PROPS_Y'][$locationPropertyId]['VARIANTS'][$key]['SELECTED'] = 'Y';
                    $arResult['ORDER_PROP']['USER_PROPS_Y'][$locationPropertyId]['VALUE'] = $arLocation['ID'];
                };
            };*/
        }
    }

    /**
     * @param $order
     * @param $arUserResult
     * @param $request
     * @param $arParams
     * @param $arResult
     * @throws ArgumentException
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws SystemException
     *
     */
    public static function setZip($order, &$arUserResult, $request, &$arParams, &$arResult)
    {
        $settings = Settings::getList();

        if ($settings['TF_LOCATION_DELIVERY_ZIP'] != 'Y') return;

        $orderFake           = \Bitrix\Sale\Order::create(\Bitrix\Main\Application::getInstance()->getContext()->getSite());
        $propertyCollection = $orderFake->getPropertyCollection();
        $zipPropertyId      = null;
        $checkedPersonTypeId= self::getCheckedPersonTypeId($arResult);

        foreach ($propertyCollection as $property)
        {
            $arProperty = $property->getProperty();

            if ($arProperty['UTIL'] == 'Y') continue;

            if(($arProperty['IS_ZIP'] === 'Y')
                && ($arProperty['PERSON_TYPE_ID'] == $checkedPersonTypeId)
            ) {
                $zipPropertyId  = $arProperty['ID'];
                break;
            }
        }

        if (!$zipPropertyId) return;

        if (!Storage::isEmpty())
        {
            $zip = Location::getZipById(Storage::getLocationId());
            if (is_array($zip))
                $zip = reset($zip);

            if (!empty($zip))
            {
                foreach ($arResult['JS_DATA']['ORDER_PROP']['properties'] as &$property){

                    if ($property['ID'] == $zipPropertyId)
                        $property['VALUE'] = [$zip];
                }
            }
        }
    }
}