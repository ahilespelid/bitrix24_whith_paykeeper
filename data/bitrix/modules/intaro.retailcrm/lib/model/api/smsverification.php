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
 * Class SmsVerification
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class SmsVerification extends AbstractApiModel
{
    /**
     * ���� ��������. (Y-m-d H:i:s)
     *
     * @var \DateTime
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * ���� ��������� ����� �����. (Y-m-d H:i:s)
     *
     * @var \DateTime
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("expiredAt")
     */
    public $expiredAt;

    /**
     * ���� �������� �����������. (Y-m-d H:i:s)
     *
     * @var \DateTime
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("verifiedAt")
     */
    public $verifiedAt;

    /**
     * ������������� ��� �������� ����
     *
     * @var string $checkId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("checkId")
     */
    public $checkId;

    /**
     * ��� ��������
     *
     * @var string $actionType
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("actionType")
     */
    public $actionType;
}
