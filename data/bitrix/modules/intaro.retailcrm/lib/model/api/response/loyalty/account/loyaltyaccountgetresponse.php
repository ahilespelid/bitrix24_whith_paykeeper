<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api\Response\Loyalty\Account
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Response\Loyalty\Account;

use Intaro\RetailCrm\Component\Json\Mapping;
use Intaro\RetailCrm\Model\Api\LoyaltyAccount;
use Intaro\RetailCrm\Model\Api\Response\AbstractApiResponseModel;

/**
 * Class LoyaltyAccountResponse
 *
 * @package Intaro\RetailCrm\Model\Api\Request\Loyalty\Account
 */
class LoyaltyAccountGetResponse extends AbstractApiResponseModel
{
    /**
     * ��������� ������� (��������/����������)
     *
     * @var bool $success
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("success")
     */
    public $success;

    /**
     * @var LoyaltyAccount $loyaltyAccount
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\LoyaltyAccount")
     * @Mapping\SerializedName("loyaltyAccount")
     */
    public $loyaltyAccount;
}
