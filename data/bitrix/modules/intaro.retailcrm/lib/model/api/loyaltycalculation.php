<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api\Response\Loyalty
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api;

use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class LoyaltyCalculation
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class LoyaltyCalculation
{
    /**
     * ��� ����������
     *
     * @var string $privilegeType
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("privilegeType")
     */
    public $privilegeType;
    
    /**
     * �������� ������ �� ����� � ������ ��������� ������� �� �����, ��������� � ����������
     *
     * @var float $discount
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("discount")
     */
    public $discount;
   
    /**
     * ������ � ����������
     *
     * @var float $creditBonuses
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("creditBonuses")
     */
    public $creditBonuses;
    
    /**
     * ������, ��������� ��� ��������
     *
     * @var float $maxChargeBonuses
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("maxChargeBonuses")
     */
    public $maxChargeBonuses;
    
    /**
     * ���������� � ������������ �������
     *
     * @var boolean $maximum
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("maximum")
     */
    public $maximum;
}
