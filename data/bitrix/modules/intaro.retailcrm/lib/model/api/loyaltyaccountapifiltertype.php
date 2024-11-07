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
 * Class LoyaltyAccountApiFilterType
 * @package Intaro\RetailCrm\Model\Api
 */
class LoyaltyAccountApiFilterType extends AbstractApiModel
{
    /**
     * ������ ID ������� � ��������� ����������
     *
     * @var array $ids
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("ids")
     */
    public $ids;
    
    /**
     * ������ [activated|deactivated|not_confirmed]
     *
     * @var string $status
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("status")
     */
    public $status;
    
    /**
     * ������ ������� (��)
     *
     * @var string $minAmount
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("minAmount")
     */
    public $minAmount;
    
    /**
     * ������ ������� (��)
     *
     * @var string $maxAmount
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("maxAmount")
     */
    public $maxAmount;
    
    /**
     * ����� ������� (��)
     *
     * @var string $minOrdersSum
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("minOrdersSum")
     */
    public $minOrdersSum;
    
    /**
     * ����� ������� (��)
     *
     * @var string $maxOrdersSum
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("maxOrdersSum")
     */
    public $maxOrdersSum;
    
    /**
     * ���� ����������� (��)
     *
     * @var string $createdAtFrom
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("createdAtFrom")
     */
    public $createdAtFrom;
    
    /**
     * ���� ����������� (��)
     *
     * @var string $createdAtTo
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("createdAtTo")
     */
    public $createdAtTo;
    
    /**
     * ������
     *
     * @var string $nickName
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("nickName")
     */
    public $nickName;
    
    /**
     * ����� ��������
     *
     * @var string $phoneNumber
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("phoneNumber")
     */
    public $phoneNumber;
    
    /**
     * ����� �����
     *
     * @var string $cardNumber
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("cardNumber")
     */
    public $cardNumber;
    
    /**
     * ���������� ID �������
     *
     * @var string $customerId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("customerId")
     */
    public $customerId;
    
    /**
     * ������� ID �������
     *
     * @var string $customerExternalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("customerExternalId")
     */
    public $customerExternalId;
    
    /**
     * ������ ID �������� ����������
     *
     * @var array $loyalties
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("loyalties")
     */
    public $loyalties;
    
    /**
     * �������� (array of strings)
     *
     * @var array $sites
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("sites")
     */
    public $sites;
    
    /**
     * ID �������
     *
     * @var string $id
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("id")
     */
    public $id;
}
