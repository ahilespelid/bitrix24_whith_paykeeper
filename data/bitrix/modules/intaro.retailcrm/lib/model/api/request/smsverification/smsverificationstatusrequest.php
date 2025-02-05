<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api\Response\SmsVerification
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Response\SmsVerification;

use Intaro\RetailCrm\Model\Api\AbstractApiModel;
use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class SmsVerificationStatusRequest
 *
 * @package Intaro\RetailCrm\Model\Api\Response\SmsVerification
 */
class SmsVerificationStatusRequest extends AbstractApiModel
{
    /**
     * ������������� �������� ����
     *
     * @var string $checkId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("checkId")
     */
    public $checkId;
}
