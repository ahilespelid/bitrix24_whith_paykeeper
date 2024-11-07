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
 * Class XmlSetupProps
 * @package Intaro\RetailCrm\Model\Bitrix\Xml
 */
class XmlSetupPropsCategories
{
    /**
     * XmlSetupPropsCategories constructor.
     * @param \Intaro\RetailCrm\Model\Bitrix\Xml\XmlSetupProps $products
     * @param \Intaro\RetailCrm\Model\Bitrix\Xml\XmlSetupProps $sku
     */
    public function __construct(XmlSetupProps $products, XmlSetupProps $sku)
    {
        $this->products = $products;
        $this->sku      = $sku;
    }
    
    /**
     * ���������������� �������� �������
     *
     * @var XmlSetupProps
     */
    public $products;
    
    /**
     * ���������������� �������� �������� �����������
     *
     * @var XmlSetupProps
     */
    public $sku;
    
    /**
     * ���������������� �������� �������� �����������, ����������� � HL ������
     *
     * ������ � ���������� HL ������, �������� �������� ��������,
     * ���������������� ��-��
     *
     * @var array[][]
     */
    public $highloadblockSku;
    
    /**
     * �������������� �������� �������, ����������� � HL ������
     *
     * ������ � ���������� HL ������, �������� �������� ��������,
     * ���������������� ��-��
     *
     * @var array[][]
     */
    public $highloadblockProduct;
}
