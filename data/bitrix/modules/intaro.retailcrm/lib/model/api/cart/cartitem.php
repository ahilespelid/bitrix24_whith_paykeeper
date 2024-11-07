<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Api
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Api\Cart;

use Intaro\RetailCrm\Component\Json\Mapping;
use Intaro\RetailCrm\Model\Api\AbstractApiModel;

/**
 * Class CartItem
 *
 * @package Intaro\RetailCrm\Model\Api\Cart
 */
class CartItem extends AbstractApiModel
{
    /**
     * ID �������� �������
     *
     * @var int $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ����������
     *
     * @var $quantity
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("quantity")
     */
    public $quantity;

    /**
     * ����
     *
     * @var float $price
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("price")
     */
    public $price;

    /**
     * ���� ���������� � �������
     *
     * @var \DateTime $createdAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * ���� ���������� �������� �������
     *
     * @var \DateTime $updatedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("updatedAt")
     */
    public $updatedAt;

    /**
     * �������� �����������
     *
     * @var array $offer
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("offer")
     */
    public $offer;
}
