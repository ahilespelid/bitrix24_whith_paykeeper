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
 * Class History
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class History extends AbstractApiModel
{
    /**
     * ���������� ������������� ������ � �������
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ���� �������� ���������
     *
     * @var \DateTime $createdAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * ������� �������� ��������
     *
     * @var string $created
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("created")
     */
    public $created;

    /**
     * ������� �������� ��������
     *
     * @var string $deleted
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("deleted")
     */
    public $deleted;

    /**
     * �������� ���������
     *
     * @var string $source
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("source")
     */
    public $source;

    /**
     * ������������
     *
     * @var \Intaro\RetailCrm\Model\Api\User $user
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\User")
     * @Mapping\SerializedName("user")
     */
    public $user;

    /**
     * ��� ������������� ����
     *
     * @var string $field
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("field")
     */
    public $field;

    /**
     * ���������� � ����� api, ���������������� ��� ����� ���������
     *
     * @var array $apiKey
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("apiKey")
     */
    public $apiKey;

    /**
     * ������ �������� ��������
     *
     * @var string $oldValue
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("oldValue")
     */
    public $oldValue;

    /**
     * ����� �������� ��������
     *
     * @var string $newValue
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("newValue")
     */
    public $newValue;

    /**
     * ������
     *
     * @var \Intaro\RetailCrm\Model\Api\Customer $customer
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Customer")
     * @Mapping\SerializedName("customer")
     */
    public $customer;

    /**
     * �����
     *
     * @var \Intaro\RetailCrm\Model\Api\Order $order
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Order")
     * @Mapping\SerializedName("order")
     */
    public $order;

    /**
     * ������� � ������
     *
     * @var \Intaro\RetailCrm\Model\Api\Item $item
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Item")
     * @Mapping\SerializedName("item")
     */
    public $item;

    /**
     * �����
     *
     * @var \Intaro\RetailCrm\Model\Api\Payment $payment
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Payment")
     * @Mapping\SerializedName("payment")
     */
    public $payment;

    /**
     * ����� �������
     *
     * @var \Intaro\RetailCrm\Model\Api\Address $address
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Address")
     * @Mapping\SerializedName("address")
     */
    public $address;

    /**
     * ���������� � [������|�������], ������� ��������� ����� ����������� � ������� ��������
     *
     * @var array $combinedTo
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("combinedTo")
     */
    public $combinedTo;

    /**
     * ���������� � �������, ������� ��������� ����� ����������� � ������� ��������
     *
     * @var \Intaro\RetailCrm\Model\Api\CustomerContact $customerContact
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\CustomerContact")
     * @Mapping\SerializedName("customerContact")
     */
    public $customerContact;

    /**
     * ���������� � ��������
     *
     * @var \Intaro\RetailCrm\Model\Api\Company $company
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Company")
     * @Mapping\SerializedName("company")
     */
    public $company;
}
