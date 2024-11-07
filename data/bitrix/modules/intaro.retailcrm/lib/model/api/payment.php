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
 * Class Payment
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Payment extends AbstractApiModel
{
    /**
     * ���������� ID
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ��� ������
     *
     * @var string $type
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("type")
     */
    public $type;

    /**
     * ������� ID �������
     *
     * @var string $externalId
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("externalId")
     */
    public $externalId;
}
