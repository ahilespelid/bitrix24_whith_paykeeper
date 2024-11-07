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
 * Class SerializedOrder
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class SerializedOrder
{
    /**
     * �������� ������ �� ���� �����
     *
     * @var double $discountManualAmount
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("discountManualAmount")
     */
    public $discountManualAmount;
    
    /**
     * ���������� ������ �� ���� �����. ������� ��������� ��� �������� �� 2 ������ ����� �������
     *
     * @var double $discountManualPercent
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("discountManualPercent")
     */
    public $discountManualPercent;
    
    /**
     * ������
     *
     * @var \Intaro\RetailCrm\Model\Api\SerializedRelationCustomer
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\SerializedRelationCustomer")
     * @Mapping\SerializedName("customer")
     */
    public $customer;
    
    /**
     * @var array $items
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\SerializedOrderProduct>")
     * @Mapping\SerializedName("items")
     */
    public $items;
    
    /**
     * @var \Intaro\RetailCrm\Model\Api\SerializedOrderDelivery
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\SerializedOrderDelivery")
     * @Mapping\SerializedName("delivery")
     */
    public $delivery;
}
