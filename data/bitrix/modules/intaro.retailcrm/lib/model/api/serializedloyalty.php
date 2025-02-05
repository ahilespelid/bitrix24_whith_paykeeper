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
 * Class SerializedLoyaltyOrder
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class SerializedLoyalty
{
    /**
     * �������� ��������� ����������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;
    
    /**
     * ���� ��� �������� �������
     *
     * @var float $chargeRate
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("chargeRate")
     */
    public $chargeRate;
}
