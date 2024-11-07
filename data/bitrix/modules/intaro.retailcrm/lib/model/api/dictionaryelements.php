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
 * Class DictionaryElements
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class DictionaryElements
{
    /**
     * �������� ��������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;

    /**
     * ��� ��������
     *
     * @var string $code
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("code")
     */
    public $code;

    /**
     * ��� ��������
     *
     * @var string $ordering
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("ordering")
     */
    public $ordering;
}
