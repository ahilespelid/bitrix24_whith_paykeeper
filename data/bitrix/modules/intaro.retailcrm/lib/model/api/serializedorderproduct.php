<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api;

use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class SerializedOrderProduct
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class SerializedOrderProduct
{
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
     * �������� ������ �� ������� ������
     *
     * @var double $discountManualAmount
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("discountManualAmount")
     */
    public $discountManualAmount;
    
    /**
     * ���������� ������ �� ������� ������. ������� ��������� ��� �������� �� 2 ������ ����� �������
     *
     * @var double $discountManualPercent
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("discountManualPercent")
     */
    public $discountManualPercent;
    
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
     * �������� �����������
     *
     * @var \Intaro\RetailCrm\Model\Api\SerializedOrderProductOffer
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\SerializedOrderProductOffer")
     * @Mapping\SerializedName("offer")
     */
    public $offer;
    
    /**
     * ��� ����
     *
     * @var \Intaro\RetailCrm\Model\Api\PriceType
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\PriceType")
     * @Mapping\SerializedName("priceType")
     */
    public $priceType;
    
    /**
     * ������ � ��������
     *
     * @var \Intaro\RetailCrm\Model\Api\SerializedOrderDelivery
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\SerializedOrderDelivery")
     * @Mapping\SerializedName("delivery")
     */
    public $delivery;
}
