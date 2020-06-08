<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 13.03.2019
 * Time: 12:46
 *
 *
 */

namespace TwoFingers\Location\Iblock;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use TwoFingers\Location\Current;
use TwoFingers\Location\Iblock;
use TwoFingers\Location\Location;
use TwoFingers\Location\Storage;

Loc::loadMessages(__FILE__);

/**
 * Class Element
 *
 * @package TwoFingers\Location
 *
 */
class Content extends Iblock
{
    const CODE_DEFAULT          = 'default';
    const CODE                  = 'tf_location_locations';
    const PROPERTY_LOCATION_ID  = 'LOCATION_ID';
    const PROPERTY_SITE_ID      = 'SITE_ID';
    const PROPERTY_DOMAIN       = 'DOMAIN';
    const OPTION_IBLOCK_ID      = 'content-iblock-id';

    /**
     * @param Current $current
     * @param null    $siteId
     * @return array|bool|mixed|null
     * @throws ArgumentNullException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\SystemException
     *
     */
    public static function getByCurrent(Current $current, $siteId = null)
    {
        if (!$current->isDefined())
            return self::getDefault($siteId);

        $content = self::getByLocationId($current->getLocationId(), $siteId);
        if ($content)
            return $content;

        $content = self::getByName($current->getLocationName(), $siteId);
        if ($content)
            return $content;

        return self::getDefault($siteId);
    }

    /**
     * @param null $siteId
     * @return array|bool|mixed|null
     * @throws ArgumentNullException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\SystemException
     *
     */
    public static function getByStorage($siteId = null)
    {
        if (Storage::isEmpty())
            return self::getDefault($siteId);

        $content = self::getByLocationId(Storage::getLocationId(), $siteId);
        if ($content)
            return $content;

        $content = self::getByName(Storage::getLocationName(), $siteId);
        if ($content)
            return $content;

        return self::getDefault($siteId);
    }

    /**
     * @return bool|int
     * @throws ArgumentNullException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     *
     */
    public static function build()
    {
        if (!self::createType())
            return false;

        if (!self::createIblock())
            return false;

        if (!self::createStringProperty(self::PROPERTY_LOCATION_ID, 100))
            return false;

        if (!self::createStringProperty(self::PROPERTY_SITE_ID, 200))
            return false;

        if (!self::createIblockDomainProperty())
            return false;

        return self::createDefaultElement();
    }

    /**
     * @return bool|int
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    protected static function createDefaultElement()
    {
        $default = self::getDefault(null, true);
        if ($default) return true;

        $iblockId = self::getId();
        if (!$iblockId)
            return false;

        $fields = [
            'NAME'      => Loc::getMessage('TFL_IBLOCK_CONTENT_DEFAULT'),
            'CODE'      => self::CODE_DEFAULT,
            'IBLOCK_ID' => $iblockId
        ];

        return (new \CIBlockElement)->Add($fields);
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function createIblock()
    {
        if (self::getIblock()) return true;

        $id = self::create(self::CODE, Loc::getMessage('TFL_IBLOCK_CONTENT_NAME'), Loc::getMessage('TFL_IBLOCK_CONTENT_DESCRIPTION'));

        if (!$id) return false;

        Option::set('twofingers.location', self::OPTION_IBLOCK_ID, $id);

        return true;
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    public static function createIblockDomainProperty()
    {
        $property = self::getIblockDomainProperty();
        if ($property) return true;

        $iblockId = self::getId();

        if (!$iblockId) return false;

        $domainIblockId = Domain::getId();
        if (!$domainIblockId) return false;

        $arFields = Array(
            "NAME"          => Loc::getMessage('TFL_IBLOCK_CONTENT_PROP_DOMAIN'),
            "ACTIVE"        => "Y",
            "SORT"          => "300",
            "CODE"          => self::PROPERTY_DOMAIN,
            "PROPERTY_TYPE" => "E",
            "IBLOCK_ID"     => $iblockId,
            'LINK_IBLOCK_ID'=> $domainIblockId
        );

        return (new \CIBlockProperty)->Add($arFields);
    }

    /**
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    protected static function getIblockLocationProperty()
    {
        return self::getPropertyByCode(self::PROPERTY_LOCATION_ID);
    }

    /**
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    protected static function getIblockSiteProperty()
    {
        return self::getPropertyByCode(self::PROPERTY_SITE_ID);
    }


    /**
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     *
     */
    protected static function getIblockDomainProperty()
    {
        return self::getPropertyByCode(self::PROPERTY_DOMAIN);
    }

    /**
     * @param      $locationId
     * @param null $siteId
     * @param bool $reload
     * @return array|bool|mixed|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getByLocationId($locationId, $siteId = null, $reload = false)
    {
        $locationId = trim($locationId);

        if (!$locationId)
            return false;

        $filter = ['PROPERTY_' . self::PROPERTY_LOCATION_ID => $locationId];

        if (!is_null($siteId))
            $filter['PROPERTY_' . self::PROPERTY_SITE_ID] = $siteId;

        return self::getByFilter($filter, $reload);
    }

    /**
     * @param      $locationId
     * @param null $siteId
     * @param bool $reload
     * @return |null
     * @throws ArgumentNullException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\SystemException
     *
     */
    public static function getDomainByLocationId($locationId, $siteId = null, $reload = false)
    {
        if (!Loader::includeModule('iblock'))
            return null;

        $element = self::getByLocationId($locationId, $siteId, $reload);
        if (!isset($element['PROPERTIES']['DOMAIN']['VALUE'])) return null;

        $domainElement = \CIBlockElement::GetList([], ['ID' => $element['PROPERTIES']['DOMAIN']['VALUE']],
            false, false, ['ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_DOMAIN'])->Fetch();
        if (!$domainElement['PROPERTY_DOMAIN_VALUE']) return null;

        return $domainElement['PROPERTY_DOMAIN_VALUE'];
    }

    /**
     * @param      $filter
     * @param bool $reload
     * @return array|mixed|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getByFilter(array $filter, $reload = false)
    {
        $cacheId    = md5(__METHOD__ . serialize($filter));
        $cache      = Application::getInstance()->getManagedCache();

        if (!$reload && $cache->read(Location::CACHE_TTL, $cacheId))
            return $cache->get($cacheId);

        $iblockId = self::getId();
        if (!$iblockId || !Loader::includeModule('iblock')) return null;

        $filter['IBLOCK_ID'] = $iblockId;

        $obElement = \CIBlockElement::GetList([], $filter)->GetNextElement();

        if ($obElement) {
            $element                = $obElement->GetFields();
            $element['PROPERTIES']  = $obElement->GetProperties();
        } else {
            $element = [];
        }

        $cache->set($cacheId, $element);

        return $element;
    }

    /**
     * @param null $siteId
     * @param bool $reload
     * @return array|mixed|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getDefault($siteId = null, $reload = false)
    {
        $filter = ['CODE' => self::CODE_DEFAULT];

        if (!is_null($siteId))
            $filter['PROPERTY_' . self::PROPERTY_SITE_ID] = $siteId;
        
        return self::getByFilter($filter, $reload);
    }
    
    /**
     * @param      $name
     * @param null $siteId
     * @param bool $reload
     * @return array|mixed|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     *
     */
    public static function getByName($name, $siteId = null, $reload = false)
    {
        $name = trim($name);

        if (!strlen($name)) return false;

        $filter = ['=NAME' => $name];

        if (!is_null($siteId))
            $filter['PROPERTY_' . self::PROPERTY_SITE_ID] = $siteId;

        return self::getByFilter($filter, $reload);
    }
}