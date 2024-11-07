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
 * Class OrderProduct
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class OrderProduct
{
    /**
     * ���������� ��������� �������
     *
     * @var double $bonusesChargeTotal
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("bonusesChargeTotal")
     */
    public $bonusesChargeTotal;
    
    /**
     * ���������� ����������� �������
     *
     * @var double $bonusesCreditTotal
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("bonusesCreditTotal")
     */
    public $bonusesCreditTotal;
    
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
     * ���� ������/SKU
     *
     * @var double $initialPrice
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("initialPrice")
     */
    public $initialPrice;
    
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
     * ������ ���
     *
     * @var string $vatRate
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("vatRate")
     */
    public $vatRate;
    
    /**
     * ����������
     *
     * @var float $quantity
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("quantity")
     */
    public $quantity;
}
