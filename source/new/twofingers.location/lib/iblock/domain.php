<?php
/**
 * Created by PhpStorm.
 * User: Павел
 * Date: 17.12.2019
 * Time: 14:02
 *
 * @author Pavel Shulaev (https://rover-it.me)
 */

namespace TwoFingers\Location\Iblock;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main;
use TwoFingers\Location\Iblock;

Loc::loadMessages(__FILE__);

class Domain extends Iblock
{
    const PROPERTY_DOMAIN   = 'DOMAIN';
    const CODE              = 'tf_location_domains';
    const OPTION_IBLOCK_ID  = 'domain-iblock-id';

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws Main\ArgumentException
     * @throws Main\ArgumentOutOfRangeException
     * @throws Main\LoaderException
     * @throws Main\ObjectPropertyException
     * @throws Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     */
    public static function build()
    {
        if (!self::createType())
            return false;

        if (!self::createIblock())
            return false;

        if (!self::createStringProperty(self::PROPERTY_DOMAIN, 100, 'Y'))
            return false;

        return true;
    }

    /**
     * @return bool
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @author Pavel Shulaev (https://rover-it.me)
     */
    public static function createIblock()
    {
        if (self::getIblock()) return true;

        $id = self::create(self::CODE, Loc::getMessage('TFL_IBLOCK_DOMAIN_NAME'), Loc::getMessage('TFL_IBLOCK_DOMAIN_DESCRIPTION'));

        if (!$id) return false;

        Option::set('twofingers.location', self::OPTION_IBLOCK_ID, $id);

        return true;
    }

    /**
     * @return array|null
     * @throws ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @author Pavel Shulaev (https://rover-it.me)
     */
    protected static function getIblockDomainProperty()
    {
        return self::getPropertyByCode(self::PROPERTY_DOMAIN);
    }
}