<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Bitrix\Xml
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */
namespace Intaro\RetailCrm\Model\Bitrix\Xml;

/**
 * Class XmlSetupProps
 *
 * @package Intaro\RetailCrm\Model\Bitrix\Xml
 */
class XmlSetupProps
{
    /**
     * XmlSetupProps constructor.
     * @param array      $names
     * @param array      $units
     * @param array|null $pictures
     */
    public function __construct(array $names, array $units, ?array $pictures)
    {
        $this->names = $names;
        $this->units = $units;
        $this->pictures = $pictures;
    }
    
    /**
     * �������� �������
     *
     * @var array
     */
    public $names;
    
    /**
     * ���� ���������
     *
     * @var array
     */
    public $units;
    
    /**
     * ��������, �� ������� ����� ����� ��������
     *
     * @var array
     */
    public $pictures;
}
