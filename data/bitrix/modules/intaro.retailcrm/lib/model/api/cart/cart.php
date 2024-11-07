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
 * Class Cart
 *
 * @package Intaro\RetailCrm\Model\Api\Cart
 */
class Cart extends AbstractApiModel
{
    /**
     * ������� ID �������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;

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
     * ���� ���������� ���������� �������
     *
     * @var \DateTime $updatedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("updatedAt")
     */
    public $updatedAt;

    /**
     * ���� ����������� ��������� ��������
     *
     * @var \DateTime $droppedAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("droppedAt")
     */
    public $droppedAt;

    /**
     * ������
     *
     * @var string $link
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("link")
     */
    public $link;

    /**
     * �������� �������
     *
     * @var array $items
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Cart\CartItem>")
     * @Mapping\SerializedName("items")
     */
    public $items;
}
