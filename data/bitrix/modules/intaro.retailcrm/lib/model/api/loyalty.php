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
 * Class Loyalty
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Loyalty
{
    /**
     * ��������
     *
     * @var array $levels
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\LoyaltyLevel>")
     * @Mapping\SerializedName("levels")
     */
    public $levels;

    /**
     * �������
     *
     * @var bool $active
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("active")
     */
    public $active;

    /**
     * �������������
     *
     * @var bool $blocked
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("blocked")
     */
    public $blocked;

    /**
     * Id ��������� ����������
     *
     * @var int $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * �������������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;

    /**
     * �������������
     *
     * @var bool $confirmSmsCharge
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("confirmSmsCharge")
     */
    public $confirmSmsCharge;

    /**
     * �������������
     *
     * @var bool $confirmSmsRegistration
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("confirmSmsRegistration")
     */
    public $confirmSmsRegistration;

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
     * ���� �������
     *
     * @var \DateTime $activatedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("activatedAt")
     */
    public $activatedAt;

    /**
     * ���� ���������
     *
     * @var \DateTime $deactivatedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("deactivatedAt")
     */
    public $deactivatedAt;

    /**
     * ���� ����������
     *
     * @var \DateTime $blockedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("blockedAt")
     */
    public $blockedAt;
}
