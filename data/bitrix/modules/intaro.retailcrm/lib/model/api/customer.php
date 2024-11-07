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
 * Class Customer
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Customer extends AbstractApiModel
{
    /**
     * ID [��������|��������������] �������
     *
     * @var int $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ������� ID [��������|��������������] �������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;

    /**
     * ������� ������������� [��������|��������������] ������� � ��������� �������
     *
     * @var string $uuid
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("uuid")
     */
    public $uuid;

    /**
     * ��� ������� (������������� ��� �������)
     *
     * @var string $type
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("type")
     */
    public $type;

    /**
     * ���������� ���� �������������� ������� �������� ��������
     *
     * @var bool $isMain
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("isMain")
     */
    public $isMain;

    /**
     * ��������� �������� �� ��������
     *
     * @var bool $subscribed
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("subscribed")
     */
    public $subscribed;

    /**
     * ���� Daemon Collector
     *
     * @var bool $browserId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("browserId")
     */
    public $browserId;

    /**
     * �������� �� ������ ���������� ����� �������������� �������
     *
     * @var boolean $isContact
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("isContact")
     */
    public $isContact;

    /**
     * ���� �������� � �������
     *
     * @var \DateTime $createdAt
     *
     * @Mapping\Type("DateTime<'Y-m-d H:i:s'>")
     * @Mapping\SerializedName("createdAt")
     */
    public $createdAt;

    /**
     * ���
     *
     * @var string $firstName
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("firstName")
     */
    public $firstName;

    /**
     * �������
     *
     * @var string $lastName
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("lastName")
     */
    public $lastName;

    /**
     * ��������
     *
     * @var string $patronymic
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("patronymic")
     */
    public $patronymic;

    /**
     * ����� ����������� �����
     *
     * @var string $email
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("email")
     */
    public $email;

    /**
     * ��������
     *
     * @var \Intaro\RetailCrm\Model\Api\Phone[] $phones
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Phone>")
     * @Mapping\SerializedName("phones")
     */
    public $phones;

    /**
     * ���� ��������
     *
     * @var \DateTime
     *
     * @Mapping\Type("DateTime<'Y-m-d'>")
     * @Mapping\SerializedName("birthday")
     */
    public $birthday;

    /**
     * ���
     *
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("sex")
     */
    public $sex;

    /**
     * ID ���������, � �������� �������� ������
     *
     * @var int $managerId
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("managerId")
     */
    public $managerId;

    /**
     * ���������
     *
     * @var Contragent $contragent
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Contragent")
     * @Mapping\SerializedName("contragent")
     */
    public $contragent;

    /**
     * ������ ���������������� �����
     *
     * @var array $customFields
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("customFields")
     */
    public $customFields;

    /**
     * �������, � �������� ������ ������
     *
     * @var string $site
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("site")
     */
    public $site;

    /**
     * ������������
     *
     * @var string $nickName
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("nickName")
     */
    public $nickName;

    /**
     * �����
     *
     * @var Address $address
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Address")
     * @Mapping\SerializedName("address")
     */
    public $address;

    /**
     * ������
     *
     * @var array $addresses
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Address>")
     * @Mapping\SerializedName("addresses")
     */
    public $addresses;

    /**
     * �������� �����
     *
     * @var Address $mainAddress
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Address")
     * @Mapping\SerializedName("mainAddress")
     */
    public $mainAddress;

    /**
     * ��������
     *
     * @var array $companies
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Company>")
     * @Mapping\SerializedName("companies")
     */
    public $companies;

    /**
     * �������� ��������
     *
     * @var Company $mainCompany
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Company")
     * @Mapping\SerializedName("mainCompany")
     */
    public $mainCompany;

    /**
     * ���������� ����
     *
     * @var array $customerContacts
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\CustomerContact>")
     * @Mapping\SerializedName("customerContacts")
     */
    public $customerContacts;

    /**
     * �������� ���������� ����
     *
     * @var CustomerContact $mainCustomerContact
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\CustomerContact")
     * @Mapping\SerializedName("mainCustomerContact")
     */
    public $mainCustomerContact;

    /**
     * ������������ ������
     *
     * @var double $mainCustomerContact
     *
     * @Mapping\Type("double")
     * @Mapping\SerializedName("personalDiscount")
     */
    public $personalDiscount;
}
