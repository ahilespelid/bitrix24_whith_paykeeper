<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Service
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\Base;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as Highloadblock;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;

/**
 * Class Hl
 *
 * ��������� �������� DataManager ��� HL-������
 *
 * @package Intaro\RetailCrm\Service
 */
class Hl
{
    /**
     * ��������� DataManager ������ ���������� HLBlock
     *
     * @param int $hlBlockId
     *
     * @return \Bitrix\Main\Entity\DataManager|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getHlClassById(int $hlBlockId): ?DataManager
    {
        $entity = self::getBaseEntityByHlId($hlBlockId);

        return $entity->getDataClass();
    }


    /**
     * @param int $HlBlockId
     *
     * @return \Bitrix\Main\Entity\Base|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function getBaseEntityByHlId(int $HlBlockId): ?Base
    {
        Loader::includeModule('highloadblock');

        $hlblock = Highloadblock\HighloadBlockTable::getById($HlBlockId)->fetch();

        if (!$hlblock) {
            return null;
        }

        return Highloadblock\HighloadBlockTable::compileEntity($hlblock);
    }

    /**
     * @param string|null $tableName
     *
     * @return \Bitrix\Main\Entity\Base|null
     */
    public static function getBaseEntityByTableName(?string $tableName): ?Base
    {
        if (!$tableName) {
            return null;
        }

        try {
            Loader::includeModule('highloadblock');

            $hlblock = Highloadblock\HighloadBlockTable::query()
                ->addSelect('*')
                ->where('TABLE_NAME', '=', $tableName)
                ->exec()
                ->fetch();

            if (!$hlblock) {
                return null;
            }

            return Highloadblock\HighloadBlockTable::compileEntity($hlblock);
        } catch (ObjectPropertyException | ArgumentException | SystemException | LoaderException $exception) {
            AddMessage2Log($exception->getMessage());

            return null;
        }
    }

    /**
     * ��������� DataManager ������ ���������� HLBlock �� �������� �������
     *
     * @param string $name
     * @return \Bitrix\Main\Entity\DataManager|null|string
     */
    public static function getHlClassByTableName(string $name)
    {
        $entity = self::getBaseEntityByTableName($name);

        if ($entity instanceof Base) {
            return $entity->getDataClass();
        }

        return null;
    }
}
