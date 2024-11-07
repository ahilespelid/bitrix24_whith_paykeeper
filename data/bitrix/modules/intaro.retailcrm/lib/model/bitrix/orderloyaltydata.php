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
 * Class OrderLoyaltyData
 *
 * ��������� HL-���� loyalty_program
 *
 * @package Intaro\RetailCrm\Model\Bitrix
 */
class OrderLoyaltyData
{
    /**
     * ID
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("ID")
     */
    public $id;

    /**
     * ID ������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_ORDER_ID")
     */
    public $orderId;

    /**
     * ID ������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_ITEM_ID")
     */
    public $itemId;

    /**
     * ID ������������ ����
     *
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("UF_CHECK_ID")
     */
    public $checkId;

    /**
     * ������� �� ������
     *
     * @var bool
     *
     * @Mapping\Type("bool")
     * @Mapping\SerializedName("UF_IS_DEBITED")
     */
    public $isDebited;

    /**
     * ���������� � �������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_QUANTITY")
     */
    public $quantity;

    /**
     * ID ������� ������ � �������
     *
     * @var int $basketItemPositionId
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_ITEM_POS_ID")
     */
    public $basketItemPositionId;

    /**
     * ������ ������� ������ �� ������� ������ � �������
     *
     * ��� ������ ������������ � �������� ������ � ��������
     *
     * @var float $defaultDiscount
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("UF_DEF_DISCOUNT")
     */
    public $defaultDiscount;

    /**
     * �������� ������
     *
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("UF_NAME")
     */
    public $name;

    /**
     * ���������� ����������� ������� �� �������
     *
     * @var float
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("UF_BONUS_COUNT")
     */
    public $bonusCount;

    /**
     * ���������� ����������� ������� �� ����� ������
     *
     * @var float
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("UF_BONUS_COUNT_TOTAL")
     */
    public $bonusCountTotal;
}
