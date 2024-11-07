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
 * Class RequiredFields
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class RequiredFields
{
    /**
     * �������� ����
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;

    /**
     * ��� ����
     *
     * @var string $code
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("code")
     */
    public $code;

    /**
     * ��������� ��������
     *
     * @var string $entity
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("entity")
     */
    public $entity;

    /**
     * ��� ����
     *
     * @var string $type
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("type")
     */
    public $type;

    /**
     * ����: ��������� ����
     *
     * @var bool $custom
     *
     * @Mapping\Type("boolean")
     * @Mapping\SerializedName("custom")
     */
    public $custom;

    /**
     * ��������� �������� ��� ��������� �����
     *
     * @var \Intaro\RetailCrm\Model\Api\DictionaryElements[] $dictionaryElements
     *
     * @Mapping\Type("array<Intaro\RetailCrm\Model\Api\DictionaryElements>")
     * @Mapping\SerializedName("dictionaryElements")
     */
    public $dictionaryElements;
}
