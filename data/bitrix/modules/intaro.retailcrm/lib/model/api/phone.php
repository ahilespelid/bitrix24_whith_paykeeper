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
 * Class Phone
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Phone extends AbstractApiModel
{
    /**
     * ����� ��������
     *
     * @var string $number
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("number")
     */
    public $number;

    /**
     * ������ ����� ��������. ������������ ������ � �������, ������������ ��� ������������.
     *
     * @var string $oldNumber
     */
    public $oldNumber;
}
