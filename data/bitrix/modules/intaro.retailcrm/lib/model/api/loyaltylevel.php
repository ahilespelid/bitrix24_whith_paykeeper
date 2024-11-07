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
 * Class LoyaltyLevel
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class LoyaltyLevel
{
    /**
     * ID �������
     *
     * @var int $id
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("id")
     */
    public $id;
    
    /**
     * �������� ������
     *
     * @var string $name
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("name")
     */
    public $name;
    
    /**
     * ��� ������.
     *
     * ��������� ��������:
     * bonus_percent - ������ �� ���������
     * bonus_converting - ������:  ���������� 1 ����� �� ������ 10 ������ �������
     * discount - ��������� �������
     *
     * @var string $type
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("type")
     */
    public $type;
    
    /**
     * ������ ������, ������� ��� ���� ���������� ������� ��� ������� �� ������� ����
     *
     * @var float $privilegeSize
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("privilegeSize")
     */
    public $privilegeSize;
    
    /**
     * ������ ������, ������� ��� ���� ���������� ������� ��� ��������� �������
     *
     * @var float $privilegeSizePromo
     *
     * @Mapping\Type("float")
     * @Mapping\SerializedName("privilegeSizePromo")
     */
    public $privilegeSizePromo;
}
