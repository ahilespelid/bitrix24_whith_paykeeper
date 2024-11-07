<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Order;

use Intaro\RetailCrm\Component\Json\Mapping;
use Intaro\RetailCrm\Model\Api\AbstractApiModel;

/**
 * Class OrderProduct
 *
 * @package Intaro\RetailCrm\Model\Api\Order
 */
class OrderProduct extends AbstractApiModel
{
    /**
     * ID ������� � ������
     *
     * @var int $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;
    
    /**
     * ������� �������������� ������� � ������
     *
     * @var array $externalIds
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\CodeValueModel>")
     * @Mapping\SerializedName("externalIds")
     */
    public $externalIds;
    
    /**
     * �������� �����������
     *
     * @var array $offer
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("offer")
     */
    public $offer;
    
    /**
     * ���� ������/SKU
     *
     * @var double $initialPrice
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("initialPrice")
     */
    public $initialPrice;

    /**
     * ����������
     *
     * @var float $quantity
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("quantity")
     */
    public $quantity;

    /**
     * ����� �������� ������ �� �������� �������
     *
     * @var array $discounts
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Order\OrderProductDiscountItem>")
     * @Mapping\SerializedName("discounts")
     */
    public $discounts;

    /**
     * �������� �������� ������ �� ������� ������ c ������ ���� ������ �� ����� � �����
     *
     * @var double $discountTotal
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("discountTotal")
     */
    public $discountTotal;
    
    /**
     * ����� �������� ��� ���������� � ��������� ����������
     *
     * @var array $prices
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Order\OrderProductPriceItem>")
     * @Mapping\SerializedName("prices")
     */
    public $prices;
    
    /**
     * ��� ����
     *
     * @var array $priceType
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\PriceType>")
     * @Mapping\SerializedName("priceType")
     */
    public $priceType;
    
    /**
     * �������������� �������� ������� � ������
     *
     * @var array $properties
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("properties")
     */
    public $properties;
}
