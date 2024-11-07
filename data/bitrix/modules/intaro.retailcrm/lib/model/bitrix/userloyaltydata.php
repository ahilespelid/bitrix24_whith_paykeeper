<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Model\Bitrix
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Model\Bitrix;

use Intaro\RetailCrm\Component\Json\Mapping;

/**
 * Class UserLoyaltyData
 *
 * ��������� ��������� �������������� ���� �������� User,
 * �������������� � ������� b_uts_user
 *
 * @package Intaro\RetailCrm\Model\Bitrix
 */
class UserLoyaltyData
{
    /**
     * ����� �������� ����� � ��������� ����������
     *
     * @var string
     *
     * @Mapping\Type("string")
     * @Mapping\SerializedName("UF_CARD_NUM_INTARO")
     */
    private $bonusCardNumber;
    
    /**
     * ID ������� � ��������� ����������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_LP_ID_INTARO")
     */
    private $idInLoyalty;
    
    /**
     * �������� � ��������� ��������� ����������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_AGREE_PL_INTARO")
     */
    private $isAgreeLoyaltyProgramRules;
    
    /**
     * �������� �� ��������� ������������ ������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_PD_PROC_PL_INTARO")
     */
    private $isAgreePersonalDataRules;
    
    /**
     * ������� �� ������� � ��������� ����������
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_EXT_REG_PL_INTARO")
     */
    private $isUserLoyaltyAccountActive;
    
    /**
     * �������� �� �� ����������� � LP
     *
     * @var integer
     *
     * @Mapping\Type("integer")
     * @Mapping\SerializedName("UF_REG_IN_PL_INTARO")
     */
    private $isAgreeRegisterInLoyaltyProgram;
    
    /**
     * @return string
     */
    public function getBonusCardNumber(): string
    {
        return $this->bonusCardNumber;
    }
    
    /**
     * @param string $bonusCardNumber
     */
    public function setBonusCardNumber(string $bonusCardNumber): void
    {
        $this->bonusCardNumber = $bonusCardNumber;
    }
    
    /**
     * @return int
     */
    public function getIdInLoyalty(): int
    {
        return $this->idInLoyalty;
    }
    
    /**
     * @param int $idInLoyalty
     */
    public function setIdInLoyalty(int $idInLoyalty): void
    {
        $this->idInLoyalty = $idInLoyalty;
    }
    
    /**
     * @return int
     */
    public function getIsAgreeLoyaltyProgramRules(): int
    {
        return $this->isAgreeLoyaltyProgramRules;
    }
    
    /**
     * @param int $isAgreeLoyaltyProgramRules
     */
    public function setIsAgreeLoyaltyProgramRules(int $isAgreeLoyaltyProgramRules): void
    {
        $this->isAgreeLoyaltyProgramRules = $isAgreeLoyaltyProgramRules;
    }
    
    /**
     * @return int
     */
    public function getIsAgreePersonalDataRules(): int
    {
        return $this->isAgreePersonalDataRules;
    }
    
    /**
     * @param int $isAgreePersonalDataRules
     */
    public function setIsAgreePersonalDataRules(int $isAgreePersonalDataRules): void
    {
        $this->isAgreePersonalDataRules = $isAgreePersonalDataRules;
    }
    
    /**
     * @return int
     */
    public function getIsUserLoyaltyAccountActive(): int
    {
        return $this->isUserLoyaltyAccountActive;
    }
    
    /**
     * @param int $isUserLoyaltyAccountActive
     */
    public function setIsUserLoyaltyAccountActive(int $isUserLoyaltyAccountActive): void
    {
        $this->isUserLoyaltyAccountActive = $isUserLoyaltyAccountActive;
    }
    
    /**
     * @return int
     */
    public function getIsAgreeRegisterInLoyaltyProgram(): int
    {
        return $this->isAgreeRegisterInLoyaltyProgram;
    }
    
    /**
     * @param int $isAgreeRegisterInLoyaltyProgram
     */
    public function setIsAgreeRegisterInLoyaltyProgram(int $isAgreeRegisterInLoyaltyProgram): void
    {
        $this->isAgreeRegisterInLoyaltyProgram = $isAgreeRegisterInLoyaltyProgram;
    }
}
