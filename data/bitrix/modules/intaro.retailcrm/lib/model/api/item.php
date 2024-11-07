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
 * Class Item
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Item extends AbstractApiModel
{
    /**
     * ID ������� � ������
     *
     * @var integer $id
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("id")
     */
    public $id;

    /**
     * ������� �������������� ������� � ������
     *
     * @var array $externalIds
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("externalIds")
     */
    public $externalIds;

    /**
     * �������� �����������
     *
     * @var array $offer
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("offer")
     */
    public $offer;

    /**
     * [������] �������������� �������� ������� � ������
     *
     * @var array $properties
     *
     * @Mapping\Type("array")
     * @Mapping\SerializedName("properties")
     */
    public $properties;
}
