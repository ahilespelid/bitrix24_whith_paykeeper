<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Bitrix
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Bitrix;

use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class SmsCookie
 * @package Intaro\RetailCrm\Model\Bitrix
 */
class SmsCookie
{
    /**
     * ���� �������� ���� �����������. (Y-m-d H:i:s)
     *
     * @var \DateTime $createdAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;
    
    /**
     * ���� �����������.
     *
     * @var \DateTime $expiredAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("expiredAt")
     */
    public $expiredAt;
    
    /**
     * ����������� ���.
     *
     * @var string $checkId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("checkId")
     */
    public $checkId;
    
    /**
     * ��� �����������
     *
     * @var boolean $isVerified
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("isVerified")
     */
    public $isVerified;
    
    /**
     * ��������� �������� �������� (Y-m-d H:i:s)
     *
     * @var \DateTime $resendAvailabl
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("resendAvailable")
     */
    public $resendAvailable;
}
