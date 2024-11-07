<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api\Request\Loyalty\Account
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Request\Loyalty\Account;

use Intaro\RetailCrm\Component\Json\Mapping;
use Intaro\RetailCrm\Model\Api\AbstractApiModel;

/**
 * Class LoyaltyAccountRequest
 *
 * @package Intaro\RetailCrm\Model\Api\Request\Loyalty\Account
 */
class LoyaltyAccountRequest extends AbstractApiModel
{
    /**
     * ���������� ��������� � ������ (�� ��������� ����� 20)
     *
     * @var integer $limit
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("limit")
     */
    public $limit;
    
    /**
     * ����� �������� � ������������ (�� ��������� ����� 1)
     *
     * @var integer $page
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("page")
     */
    public $page;
    
    /**
     * @var \Intaro\RetailCrm\Model\Api\LoyaltyAccountApiFilterType
     *
     * @Mapping\Type("\Intaro\RetailCrm\Model\Api\LoyaltyAccountApiFilterType")
     * @Mapping\SerializedName("filter")
     */
    public $filter;
}
