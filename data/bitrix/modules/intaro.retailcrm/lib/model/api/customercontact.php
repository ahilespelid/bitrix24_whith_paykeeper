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
 * Class CustomerContact
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class CustomerContact extends AbstractApiModel
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
     * ������� ID ��������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;

    /**
     * ������� �������
     *
     * @var boolean $isMain
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("isMain")
     */
    public $isMain;

    /**
     * ������
     *
     * @var Customer $customer
     *
     * @Mapping\Type("Intaro\RetailCrm\Model\Api\Customer")
     * @Mapping\SerializedName("customer")
     */
    public $customer;

    /**
     * �������� ����������� ����
     *
     * @var array $companies
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\Company>")
     * @Mapping\SerializedName("companies")
     */
    public $companies;
}
