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
 * Class XmlOffer
 * @package Intaro\RetailCrm\Model\Bitrix\Xml
 */
class XmlOffer
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $productId;

    /**
     * @var string
     */
    public $quantity;

    /**
     * @var string
     */
    public $picture;

    /**
     * @var string
     */
    public $url;

    /**
     * @var float
     */
    public $price;

    /**
     * ���������, � ������� ��������� �����
     *
     * @var array
     */
    public $categoryIds;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $xmlId;

    /**
     * @var string
     */
    public $productName;

    /**
     * @var OfferParam[]
     */
    public $params;

    /**
     * @var string
     */
    public $vendor;

    /**
     * @var Unit
     */
    public $unitCode;

    /**
     * ������ ������ (���)
     *
     * @var string
     */
    public $vatRate;

    /**
     * �����-���
     *
     * @var string
     */
    public $barcode;

    /**
     * ���������� ����
     *
     * @var mixed|null
     */
    public $purchasePrice;

    /**
     * ��� ������
     *
     * @var int
     */
    public $weight;

    /**
     * �������� ������
     *
     * @var string
     */
    public $dimensions;

    /**
     * ��� ��������
     * \Bitrix\Catalog\ProductTable::TYPE_PRODUCT - ������� �����
     * \Bitrix\Catalog\ProductTable::TYPE_SKU � ����� � ��������� �������������
     * \Bitrix\Catalog\ProductTable::TYPE_OFFER � �������� �����������
     *
     * @var int
     */
    public $productType;

    /**
     * ���������� ������/��������� ����������� (N|Y)
     *
     * @var string
     */
    public $activity;

    /**
     * ������� ���������� ������ ��� ������� �������� �����������
     * @var string | null
     */
    public ?string $activityProduct = null;

    public ?string $markable = null;

    /**
     * @param $productValue
     * @param $offerValue
     * @return mixed
     */
    public function mergeValues($productValue, $offerValue)
    {
        return empty($offerValue) ? $productValue : $offerValue;
    }
}
