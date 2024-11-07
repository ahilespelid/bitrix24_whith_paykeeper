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
 * Class PaginationResponse
 * @package Intaro\RetailCrm\Model\Api
 */
class PaginationResponse extends AbstractApiModel
{
    /**
     * ���������� ��������� � ������
     *
     * @var integer $limit
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("limit")
     */
    public $limit;
    
    /**
     * ��������� ������� (��������/����������)
     *
     * @var integer $totalCount
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("totalCount")
     */
    public $totalCount;
    
    /**
     * ������� �������� ������
     *
     * @var integer $currentPage
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("currentPage")
     */
    public $currentPage;
    
    /**
     * ����� ���������� ������� ������
     *
     * @var integer $totalPageCount
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("totalPageCount")
     */
    public $totalPageCount;
}
