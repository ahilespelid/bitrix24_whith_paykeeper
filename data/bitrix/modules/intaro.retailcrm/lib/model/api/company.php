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
 * Class Company
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Company extends AbstractApiModel
{
    /**
     * ID ��������
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ������� ������������� �������� � ��������� �������
     *
     * @var string $uuid
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("uuid")
     */
    public $uuid;

    /**
     * ������� ��������
     *
     * @var boolean $isMain
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("isMain")
     */
    public $isMain;

    /**
     * �������
     *
     * @var string $site
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("site")
     */
    public $site;

    /**
     * ������� ID ��������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;

    /**
     * ����������
     *
     * @var string $active
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("active")
     */
    public $active;

    /**
     * ������������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;

    /**
     * �����
     *
     * @var string $brand
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("brand")
     */
    public $brand;

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
     * ���������
     *
     * @var Contragent $contragent
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Contragent")
     * @Mapping\SerializedName("contragent")
     */
    public $contragent;

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
     * ������������� ������ ���������������� �����
     *
     * @var array $customFields
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("customFields")
     */
    public $customFields;
}
