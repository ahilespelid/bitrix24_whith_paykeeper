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
 * Class Contragent
 *
 * @package Intaro\RetailCrm\Model\Api
 */
class Contragent extends AbstractApiModel
{
    /**
     * ��� �����������
     *
     * @var string $contragentType
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("contragentType")
     */
    public $contragentType;

    /**
     * ������ ������������
     *
     * @var string $legalName
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("legalName")
     */
    public $legalName;

    /**
     * ����� �����������
     *
     * @var string $legalAddress
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("legalAddress")
     */
    public $legalAddress;

    /**
     * ���
     *
     * @var string $inn
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("INN")
     */
    public $inn;

    /**
     * ���
     *
     * @var string $kpp
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("KPP")
     */
    public $kpp;

    /**
     * ����
     *
     * @var string $okpo
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("OKPO")
     */
    public $okpo;

    /**
     * ����
     *
     * @var string $ogrn
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("OGRN")
     */
    public $ogrn;

    /**
     * ������
     *
     * @var string $ogrnip
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("OGRNIP")
     */
    public $ogrnip;

    /**
     * ����� �������������
     *
     * @var string $certificateNumber
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("certificateNumber")
     */
    public $certificateNumber;

    /**
     * ���� �������������
     *
     * @var \DateTime $certificateDate
     *
     * @Mapping\Type("DateTime<'Y-m-d'>")
     * @Mapping\SerializedName("certificateDate")
     */
    public $certificateDate;

    /**
     * ���
     *
     * @var string $bik
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("BIK")
     */
    public $bik;

    /**
     * ����
     *
     * @var string $bank
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("bank")
     */
    public $bank;

    /**
     * ����� �����
     *
     * @var string $bankAddress
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("bankAddress")
     */
    public $bankAddress;

    /**
     * ����. ����
     *
     * @var string $corrAccount
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("corrAccount")
     */
    public $corrAccount;

    /**
     * ��������� ����
     *
     * @var string $bankAccount
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("bankAccount")
     */
    public $bankAccount;
}
