<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Order;

use Intaro\RetailCrm\Model\Api\AbstractApiModel;
use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class OrderProductPriceItem
 * @package Intaro\RetailCrm\Model\Api\Order
 */
class OrderProductDiscountItem extends AbstractApiModel
{
    /**
     * ��� ������
     *
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("type")
     */
    public $type;
    
    /**
     * �������� �������� ������ �� �������� �������
     *
     * @var float $amount
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("amount")
     */
    public $amount;
}
