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
class OrderProductPriceItem extends AbstractApiModel
{
    /**
     * �������� ���� c ������ ���� ������ �� ����� � �����
     *
     * @var float $price
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("price")
     */
    public $price;
    
    /**
     * ���������� ������ �� �������� ����
     *
     * @var float $quantity
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("quantity")
     */
    public $quantity;
}
