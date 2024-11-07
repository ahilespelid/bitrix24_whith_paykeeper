<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api\Request\Loyalty\Account
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api;

use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class LoyaltyAccount
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class LoyaltyAccount
{
    /**
     * ���������� ��������
     *
     * @var bool $active
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("active")
     */
    public $active;

    /**
     * Id ������� � ��������� ����������
     *
     * @var int $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ��������� ����������
     *
     * @var Loyalty
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\Loyalty")
     * @Mapping\SerializedName("loyalty")
     */
    public $loyalty;

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
     * ���������� �������
     *
     * @var float $amount
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("amount")
     */
    public $amount;

    /**
     * ���� ��������
     *
     * @var \DateTime $createdAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * @var \DateTime $activatedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("activatedAt")
     */
    public $activatedAt;

    /**
     * ������������� ��������� ���-�����������
     *
     * @var string $lastCheckId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("lastCheckId")
     */
    public $lastCheckId;

    /**
     * ����� �������
     *
     * @var float $ordersSum
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("ordersSum")
     */
    public $ordersSum;

    /**
     * ����������� ����� ������� ��� �������� �� ���� �������
     *
     * @var float $nextLevelSum
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("nextLevelSum")
     */
    public $nextLevelSum;

    /**
     * ���� ����������� ������ ��������
     *
     * @var \DateTime $confirmedPhoneAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("confirmedPhoneAt")
     */
    public $confirmedPhoneAt;

    /**
     * @var \Intaro\RetailCrm\Model\Api\LoyaltyLevel
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\LoyaltyLevel")
     * @Mapping\SerializedName("level")
     */
    public $loyaltyLevel;

    /**
     * @var \Intaro\RetailCrm\Model\Api\Customer
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\Customer")
     * @Mapping\SerializedName("customer")
     */
    public $customer;

    /**
     * @var array $customFields
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("customFields")
     */
    public $customFields;

    /**
     * ������ �������. ��������� ��������: not_confirmed, activated, deactivated
     *
     * @var string $status
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("status")
     */
    public $status;
}
