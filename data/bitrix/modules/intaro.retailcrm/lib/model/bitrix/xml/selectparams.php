<?php
/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Bitrix\Xml
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */
namespace Intaro\RetailCrm\Model\Bitrix\Xml;

/**
 * Class SelectParams
 * @package Intaro\RetailCrm\Model\Bitrix\Xml
 */
class SelectParams
{
    /**
     * ��������������� ��������
     *
     * @var array
     */
    public $configurable;

    /**
     * ������������ ��������
     *
     * @var array
     */
    public $main;

    /**
     * ����� ������������� ��������
     *
     * @var int
     */
    public $pageNumber;

    /**
     * ���������� ������� �� ��������
     *
     * @var int
     */
    public $nPageSize;

    /**
     * id ������ � ���������� �����������, ���� ������������� SKU
     *
     * @var int
     */
    public $parentId;

    /**
     * @var array
     */
    public $allParams;
}
