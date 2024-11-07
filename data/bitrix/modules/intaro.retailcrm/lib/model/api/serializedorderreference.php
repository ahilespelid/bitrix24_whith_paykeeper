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
 * Class LoyaltyCalculateRequest
 *
 * @package Intaro\RetailCrm\Model\Api\Response\SmsVerification
 */
class SerializedOrderReference
{
    /**
     * ���������� ID ������
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;
    
    /**
     * ������� ID ������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;
    
    /**
     * ����� ������
     *
     * @var string $number
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("number")
     */
    public $number;
}
