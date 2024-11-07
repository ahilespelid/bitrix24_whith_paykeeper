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
 * Class Address
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Address extends AbstractApiModel
{
    /**
     * ID ������ �������
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ������� ID
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;

    /**
     * ������������ ������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;

    /**
     * ����� ������� �������� ��������
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
     * @var string $index
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("index")
     */
    public $index;

    /**
     * �����
     *
     * @var string $city
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("city")
     */
    public $city;

    /**
     * ������
     *
     * @var string $region
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("region")
     */
    public $region;

    /**
     * �����
     *
     * @var string $street
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("street")
     */
    public $street;

    /**
     * ���
     *
     * @var string $building
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("building")
     */
    public $building;

    /**
     * ����� ��������/�����
     *
     * @var string $flat
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("flat")
     */
    public $flat;

    /**
     * ����
     *
     * @var string $floor
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("floor")
     */
    public $floor;

    /**
     * �������
     *
     * @var string $block
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("block")
     */
    public $block;

    /**
     * ��������
     *
     * @var string $house
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("house")
     */
    public $house;

    /**
     * ������
     *
     * @var string $housing
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("housing")
     */
    public $housing;

    /**
     * �����
     *
     * @var string $metro
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("metro")
     */
    public $metro;

    /**
     * �������
     *
     * @var string $notes
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("notes")
     */
    public $notes;

    /**
     * ����� � ��������� ����
     *
     * @var string $text
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("text")
     */
    public $text;

    /**
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("country")
     */
    public $country;

    /**
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("intercomCode")
     */
    public $intercomCode;
}
