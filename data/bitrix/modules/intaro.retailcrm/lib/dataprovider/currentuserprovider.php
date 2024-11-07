<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\DataProvider
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */
namespace Intaro\RetailCrm\DataProvider;

use Intaro\RetailCrm\Repository\UserRepository;
use Intaro\RetailCrm\Model\Bitrix\User;

/**
 * Class CurrentUserProvider
 * @package Intaro\RetailCrm\DataProvider
 */
class CurrentUserProvider
{
    /**
     * �������� �������� ������������
     *
     * @return \Intaro\RetailCrm\Model\Bitrix\User|null
     */
    public function get(): ?User
    {
        global $USER;
        return UserRepository::getById($USER->GetID());
    }
    
    /**
     * �������� ID ������������
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        global $USER;
        return $USER->GetID();
    }
}
