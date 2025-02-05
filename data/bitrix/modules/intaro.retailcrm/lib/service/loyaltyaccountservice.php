<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Service
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Service;

use CUser;
use Logger;
use DateTime;
use Intaro\RetailCrm\Component\ConfigProvider;
use Intaro\RetailCrm\Component\Factory\ClientFactory;
use Intaro\RetailCrm\Component\Json\Serializer;
use Intaro\RetailCrm\Component\ServiceLocator;
use Intaro\RetailCrm\Model\Api\IdentifiersPair;
use Intaro\RetailCrm\Model\Api\LoyaltyAccount;
use Intaro\RetailCrm\Model\Api\LoyaltyAccountApiFilterType;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\Account\LoyaltyAccountRequest;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\Account\LoyaltyAccountActivateRequest;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\Account\LoyaltyAccountCreateRequest;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\Account\LoyaltyAccountEditRequest;
use Intaro\RetailCrm\Model\Api\Request\SmsVerification\SmsVerificationConfirmRequest;
use Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountActivateResponse;
use Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountCreateResponse;
use Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountEditResponse;
use Intaro\RetailCrm\Model\Api\Response\SmsVerification\SmsVerificationConfirmResponse;
use Intaro\RetailCrm\Model\Api\Response\SmsVerification\SmsVerificationStatusRequest;
use Intaro\RetailCrm\Model\Api\Response\SmsVerification\SmsVerificationStatusResponse;
use Intaro\RetailCrm\Model\Api\SerializedCreateLoyaltyAccount;
use Intaro\RetailCrm\Model\Api\SmsVerificationConfirm;
use Intaro\RetailCrm\Model\Bitrix\User;
use Intaro\RetailCrm\Model\Bitrix\UserLoyaltyData;
use Intaro\RetailCrm\Repository\UserRepository;

/**
 * Class LoyaltyAccountService
 */
class LoyaltyAccountService
{
    public const STANDARD_FIELDS = [
        'UF_AGREE_PL_INTARO'   => 'checkbox',
        'UF_PD_PROC_PL_INTARO' => 'checkbox',
        'PERSONAL_PHONE'       => 'text',
    ];

    /**
     * @var \Intaro\RetailCrm\Model\Bitrix\User|null
     */
    private $user;

    /**
     * �������� ������ �������� ��������� �����������
     *
     * @param string $checkId ������������� �������� ����
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\SmsVerification\SmsVerificationStatusResponse|null
     */
    public function getSmsStatus(string $checkId): ?SmsVerificationStatusResponse
    {
        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();
        $request = new SmsVerificationStatusRequest();
        $request->checkId = $checkId;

        return $client->checkStatusPlVerification($request);
    }

    /**
     * @param int $loyaltyId
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountActivateResponse|null
     */
    public function activateLoyaltyAccount(int $loyaltyId): ?LoyaltyAccountActivateResponse
    {
        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();

        $activateRequest = new LoyaltyAccountActivateRequest();
        $activateRequest->loyaltyId = $loyaltyId;

        $response = $client->activateLoyaltyAccount($activateRequest);

        if ($response === null) {
            return null;
        }

        if ($response->success && $response->loyaltyAccount->activatedAt instanceof DateTime) {
            return $response;
        }

        Utils::handleApiErrors($response);

        return $response;
    }

    /**
     * @param string $phone
     * @param string $card
     * @param string $externalId
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountCreateResponse|null
     */
    public function createLoyaltyAccount(string $phone, string $card, string $externalId): ?LoyaltyAccountCreateResponse
    {
        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();

        $sitesAvailable = ConfigProvider::getSitesAvailable();

        $createRequest = new LoyaltyAccountCreateRequest();
        $createRequest->site = $sitesAvailable;
        $createRequest->loyaltyAccount = new SerializedCreateLoyaltyAccount();
        $createRequest->loyaltyAccount->phoneNumber = $phone ?? '';
        $createRequest->loyaltyAccount->cardNumber = $card ?? '';
        $createRequest->loyaltyAccount->customFields = [];

        $createRequest->loyaltyAccount->customer = new IdentifiersPair();
        $createRequest->loyaltyAccount->customer->externalId = $externalId;


        $createResponse = $client->createLoyaltyAccount($createRequest);

        if ($createResponse instanceof LoyaltyAccountCreateResponse) {
            Utils::handleApiErrors($createResponse, GetMessage('REGISTER_ERROR'));
        }

        return $createResponse;
    }

    /**
     * @param \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountCreateResponse|null $createResponse
     * @param int                                                                                    $userId
     */
    public function activateLpUserInBitrix(?LoyaltyAccountCreateResponse $createResponse, int $userId): void
    {
        //���� �������� �� ������
        if (($createResponse !== null)
            && $createResponse->success === true
        ) {
            global $USER_FIELD_MANAGER;

            $USER_FIELD_MANAGER->Update('USER', $userId, [
                'UF_EXT_REG_PL_INTARO' => $createResponse->loyaltyAccount->active === true ? 'Y' : '',
                'UF_LP_ID_INTARO'      => $createResponse->loyaltyAccount->id,
            ]);

            Utils::handleApiErrors($createResponse, GetMessage('REGISTER_ERROR'));
        } elseif ($this->proveUserInLpExists($createResponse)) {
            global $USER_FIELD_MANAGER;

            /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
            $client = ClientFactory::createClientAdapter();

            $sitesAvailable = ConfigProvider::getSitesAvailable();

            $getRequest = new LoyaltyAccountRequest();

            $getRequest->filter = new LoyaltyAccountApiFilterType();
            $getRequest->filter->sites = is_array($sitesAvailable) ? $sitesAvailable : [$sitesAvailable];
            $getRequest->filter->customerExternalId = (string)$userId;


            $getResponse = $client->getLoyaltyAccounts($getRequest);

            if ($getResponse instanceof LoyaltyAccountCreateResponse) {
                Utils::handleApiErrors($getResponse, GetMessage('REGISTER_ERROR'));
            }

            $USER_FIELD_MANAGER->Update('USER', $userId, [
                'UF_EXT_REG_PL_INTARO' => ($getResponse->loyaltyAccounts)[0]->active === true ? 'Y' : '',
                'UF_LP_ID_INTARO'      => ($getResponse->loyaltyAccounts)[0]->id,
            ]);
        }
    }

    /**
     * ������������ �����������
     *
     * @param string $code    ����������� ���
     * @param string $checkId ������������� �������� ����
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\SmsVerification\SmsVerificationConfirmResponse|null
     */
    public function confirmVerification(string $code, string $checkId): ?SmsVerificationConfirmResponse
    {
        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();

        $request = new SmsVerificationConfirmRequest();
        $request->verification = new SmsVerificationConfirm();
        $request->verification->code = $code;
        $request->verification->checkId = $checkId;

        $response = $client->sendVerificationCode($request);

        if ($response !== null) {
            Utils::handleApiErrors($response, GetMessage('DEBITING_BONUSES_ERROR'));
        }

        return $response;
    }

    /**
     * ���������� ������ ������������ � ������� ����������
     *
     * @param $userId
     *
     * @return bool
     */
    public static function getLoyaltyPersonalStatus($userId = null): bool
    {
        if ($userId === null) {
            global $USER;

            $userId = $USER->GetID();
        }

        $userFields = CUser::GetByID($userId)->Fetch();

        return isset($userFields['UF_EXT_REG_PL_INTARO']) && $userFields['UF_EXT_REG_PL_INTARO'] === '1';
    }

    /**
     * ���������� ID �������� � ��������� ����������
     *
     * @param $userId
     *
     * @return int|null
     */
    public static function getLoyaltyAccountId($userId): ?int
    {
        $userFields = CUser::GetByID($userId)->Fetch();

        return $userFields['UF_LP_ID_INTARO'] ?? null;
    }

    /**
     * ����� ���������� �������� ��� ���� 'privilegeType'. ��������� ���� ���������� �� ������:
     *  1. ��������� ��������� �� �������� � ����. ���������.
     *  2. ������� ������� �� ������� � CRM, �������������� ���� ��� �������, ���� ��� �������.
     *  3. ������� ������� �������, �� �� ������� (���� status = deactivated).
     *  4. ��������� ���������� �������������� � CRM.
     *
     * @param $client
     * @param $userId
     * @param array $arParams
     *
     * @return string
     */
    public static function getPrivilegeType($client, $userId, array $arParams = []): string
    {
        $file = 'loyaltyStatus';
        $privilegeType = 'none';

        if (!empty($arParams['customerCorporate']['privilegeType'])) {
            $privilegeType = $arParams['crmOrder']['privilegeType'];
        } elseif (ConfigProvider::getLoyaltyProgramStatus() === 'Y' && self::getLoyaltyPersonalStatus($userId)) {
            $privilegeType = 'loyalty_level';
        }

        if (!empty($arParams['customerCorporate']) || !empty($arParams['orderCompany'])) {
            return 'none';
        }

        if ($privilegeType === 'none') {
            return 'none';
        }

        $loyaltyAccountId = self::getLoyaltyAccountId($userId);

        if ($loyaltyAccountId === null) {
            Logger::getInstance()->write('������� ������� �� �������', $file);

            return 'none';
        }

        $loyaltyAccount = $client->getLoyaltyAccount($loyaltyAccountId)->loyaltyAccount ?? null;

        if ($loyaltyAccount === null) {
            Logger::getInstance()->write('������� ������� c ID: ' . $loyaltyAccountId . ' �� �������', $file);

            return 'none';
        }

        if ($loyaltyAccount->status === 'deactivated') {
            Logger::getInstance()->write('������� ������� c ID: ' . $loyaltyAccountId . ' ���������������', $file);

            return 'none';
        }

        $loyaltyId = $loyaltyAccount->loyalty->id ?? null;

        if ($loyaltyId === null) {
            Logger::getInstance()->write('��������� ���������� �� �������', $file);

            return 'none';
        }

        $loyalty = $client->getLoyaltyLoyalty($loyaltyId)->loyalty ?? null;

        if ($loyalty === null) {
            Logger::getInstance()->write('��������� ���������� c ID: ' . $loyaltyId . ' �� �������', $file);

            return 'none';
        }

        if (!$loyalty->active) {
            Logger::getInstance()->write('��������� ���������� c ID: ' . $loyaltyId . ' ���������������', $file);

            return 'none';
        }

        return $privilegeType;
    }

    /**
     * @return array|null
     * @throws \ReflectionException
     */
    public function checkRegInLp(): ?array
    {
        global $USER;

        if ($USER->IsAuthorized()) {
            $this->user = UserRepository::getById($USER->GetID());
        }

        if (!$this->user) {
            return [];
        }

        $loyalty = $this->user->getLoyalty();

        //�������� �� ����� ������������ ������� ����������� � ��?
        if ($loyalty->getIsAgreeRegisterInLoyaltyProgram() === 1) {
            //��. ���������� �� � ���� �������?
            if (!empty($loyalty->getIdInLoyalty())) {
                //��. ������� �� ��� �������?
                if ($loyalty->getIsUserLoyaltyAccountActive() === 1) {
                    //��. ���������� ��������� "�� ���������������� � ��������� ����������"
                    return ['msg' => GetMessage('REG_COMPLETE')];
                }

                //���. ������� �� �������
                return $this->tryActivate($loyalty->getIdInLoyalty());
            }

            // ������� �� ����������. ��������, ����� ����� �� ������� ��� �������� ��������, ������� �����
            //���� ��� ����������� ���� ���������, �� �������� ��� ��� ��� ����������������
            if (count($this->getStandardFields($this->user)) === 0) {
                $createResponse = $this->registerAndActivateUser($this->user->getId(), $this->user->getPersonalPhone(), $loyalty);

                if ($createResponse === false) {
                    header('Refresh 0');
                }

                if (isset($createResponse['error']) && $createResponse['error']) {
                    $createResponse['form']['button'] = [
                        'name' => GetMessage('TRY_AGAIN'),
                        'action' => 'resetUserLpFields'
                    ];
                }

                return $createResponse;
            }

            return [
                'msg'  => GetMessage('COMPLETE_YOUR_REGISTRATION'),
                'form' => [
                    'button'         => [
                        'name'   => GetMessage('CREATE'),
                        'action' => 'saveUserLpFields',
                    ],
                    'fields'         => $this->getStandardFields($this->user),
                    'externalFields' => (array) json_decode(ConfigProvider::getLoyaltyFields(), true),
                ],
            ];
        }

        //���. ���������� ����� �� �������� ����� ����������� � ��
        return [
            'msg'  => GetMessage('INVITATION_TO_REGISTER'),
            'form' => [
                'button'         => [
                    'name'   => GetMessage('CREATE'),
                    'action' => 'saveUserLpFields',
                ],
                'fields'         => $this->getStandardFields($this->user),
                'externalFields' => (array) json_decode(ConfigProvider::getLoyaltyFields(), true),
            ],
        ];
    }

    /**
     * @param int $idInLoyalty
     *
     * @return array
     * @throws \ReflectionException
     */
    public function tryActivate(int $idInLoyalty): array
    {
        global $USER;

        /** @var \Intaro\RetailCrm\Service\CookieService $service */
        $service = ServiceLocator::get(CookieService::class);

        $smsCookie = $service->getSmsCookie('lpRegister');
        $nowTime = new DateTime();

        if ($smsCookie !== null
            && isset($smsCookie->resendAvailable)
            && $smsCookie->resendAvailable > $nowTime
        ) {
            return [
                'msg'             => GetMessage('SMS_VERIFICATION'),
                'form'            => [
                    'button' => [
                        'name'   => GetMessage('SEND'),
                        'action' => 'sendVerificationCode',
                    ],
                    'fields' => [
                        'smsVerificationCode' => [
                            'type' => 'text',
                        ],
                        'checkId'             => [
                            'type'  => 'hidden',
                            'value' => $smsCookie->checkId,
                        ],
                    ],
                ],
                'resendAvailable' => $smsCookie->resendAvailable->format('Y-m-d H:i:s'),
                'idInLoyalty'     => $idInLoyalty,
            ];
        }

        //������� ������������ �������
        $activateResponse = $this->activateLoyaltyAccount($idInLoyalty);

        if ($activateResponse === null) {
            return ['msg' => GetMessage('ACTIVATE_ERROR')];
        }

        //���� ������� �� �����, �� ������� ����������� �� ������� CRM
        if (
            ($activateResponse->success && $activateResponse->loyaltyAccount->active === true)
            || $activateResponse->errorMsg === GetMessage('ALREADY_ACTIVE')
        ) {
            $this->setLoyaltyActivateFlag($USER->GetID());

            return ['msg' => GetMessage('REG_COMPLETE')];
        }

        $requiredFields = $this->checkErrors($activateResponse);

        //���� ���� ������������� ������������ ����
        if ($_GET['activate'] === 'Y' && count($requiredFields) > 0) {
            return [
                'msg'  => GetMessage('ACTIVATE_YOUR_ACCOUNT'),
                'form' => [
                    'button'         => [
                        'name'   => GetMessage('ACTIVATE'),
                        'action' => 'activateAccount',
                    ],
                    'fields'         => $this->getStandardFields($this->user),
                    'externalFields' => $this->getExternalFields($requiredFields),
                ],
            ];
        }

        if ($_GET['activate'] !== 'Y' && count($requiredFields) > 0) {
            return [
                'msg'  => GetMessage('GO_TO_PERSONAL'),
            ];
        }

        if ($activateResponse !== null
            && isset($activateResponse->loyaltyAccount->active)
            && $activateResponse->loyaltyAccount->active === true
        ) {
            return ['msg' => GetMessage('REG_COMPLETE')];
        }

        //����� ��� �����������
        if (isset($activateResponse->verification, $activateResponse->verification->checkId)
            && $activateResponse !== null
            && !isset($activateResponse->verification->verifiedAt)
        ) {
            $smsCookie = $service->setSmsCookie('lpRegister', $activateResponse->verification);

            return [
                'msg'             => GetMessage('SMS_VERIFICATION'),
                'form'            => [
                    'button' => [
                        'name'   => GetMessage('SEND'),
                        'action' => 'sendVerificationCode',
                    ],
                    'fields' => [
                        'smsVerificationCode' => [
                            'type' => 'text',
                        ],
                        'checkId'             => [
                            'type'  => 'hidden',
                            'value' => $smsCookie->checkId,
                        ],
                    ],
                ],
                'resendAvailable' => $smsCookie->resendAvailable->format('Y-m-d H:i:s'),
                'idInLoyalty'     => $idInLoyalty,
            ];
        }

        if (
            count($activateResponse->errors) === 1
            && strpos(current($activateResponse->errors), GetMessage('FIELD_ERROR')) !== false
        ) {
            /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
            $client = ClientFactory::createClientAdapter();
            $client->getLoyaltyLoyalty((int)ConfigProvider::getLoyaltyProgramId());
        }

        return ['msg' => GetMessage('ACTIVATE_ERROR') . ' ' . $activateResponse->errorMsg ?? ''];
    }

    /**
     * @param int|null $userId
     */
    public function setLoyaltyActivateFlag(?int $userId): void
    {
        if ($userId === null) {
            return;
        }

        global $USER_FIELD_MANAGER;

        $USER_FIELD_MANAGER->Update('USER', $userId, ['UF_EXT_REG_PL_INTARO' => true]);
    }

    /**
     * @param int   $loyaltyId
     * @param array $getEntityFields
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountEditResponse|null
     */
    public function editLoyaltyAccount(int $loyaltyId, array $getEntityFields): ?LoyaltyAccountEditResponse
    {
        $request = new LoyaltyAccountEditRequest();
        $request->id = $loyaltyId;
        $request->loyaltyAccount = new LoyaltyAccount();
        $request->loyaltyAccount->phoneNumber = $getEntityFields['phoneNumber'] ?? '';
        $request->loyaltyAccount->cardNumber = $getEntityFields['cardNumber'] ?? '';

        unset($getEntityFields['phoneNumber'], $getEntityFields['cardNumber']);

        $request->loyaltyAccount->customFields = $getEntityFields;

        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();

        try {
            return $client->editLoyaltyAccount($request);
        } catch (\ReflectionException $exception){
            return null;
        }
    }

    /**
     * @param array $requireFields
     *
     * @return array
     */
    private function getExternalFields(array $requireFields): array
    {
        $fieldSettings = json_decode(ConfigProvider::getLoyaltyFields(), true);

        $missingFields = $this->compareFields(
            $requireFields,
            (array)$fieldSettings
        );

        if (count($missingFields) > 0) {
            $fieldSettings = $this->updateLoyaltyFieldsSettings();
        }

        return $this->getRequireFieldsSettings($requireFields, $fieldSettings);
    }

    /**
     * @param \Intaro\RetailCrm\Model\Bitrix\User $user
     *
     * @return array
     * @throws \ReflectionException
     */
    private function getStandardFields(User $user): array
    {
        $resultFields = [];
        $userFields = Serializer::serializeArray($user->getLoyalty());
        $userFields['PERSONAL_PHONE'] = $user->getPersonalPhone();

        foreach (self::STANDARD_FIELDS as $key => $value) {
            if ($value === 'text' && empty($userFields[$key])) {
                $resultFields[$key] = [
                    'type' => $value,
                ];
            }

            if ($value === 'checkbox' && $userFields[$key] !== 1) {
                $resultFields[$key] = [
                    'type' => $value,
                ];
            }
        }

        return $resultFields;
    }

    /**
     * @param int                                            $userId
     * @param string                                         $userPhone
     * @param \Intaro\RetailCrm\Model\Bitrix\UserLoyaltyData $loyalty
     *
     * @return array|string[]|null
     */
    private function registerAndActivateUser(
        int $userId,
        string $userPhone,
        UserLoyaltyData $loyalty
    ): ?array {
        $phone = $userPhone ?? '';
        $card = $loyalty->getBonusCardNumber() ?? '';
        $customerId = (string)$userId;

        $createResponse = $this->createLoyaltyAccount($phone, $card, $customerId);
        $this->activateLpUserInBitrix($createResponse, $userId);

        $errorMsg = Utils::getErrorMsg($createResponse);

        if ($this->proveUserInLpExists($createResponse)) {
            if (
                $createResponse->loyaltyAccount->active === false
                && $createResponse->loyaltyAccount->activatedAt === null
            ) {
                return [
                    'msg' => GetMessage('GO_TO_PERSONAL'),
                    'error' => false
                ];
            } else {
                return ['msg' => GetMessage('REG_COMPLETE'), 'error' => false];
            }
        }

        if ($errorMsg !== null) {
            return ['msg' => $errorMsg, 'error' => true];
        }

        //������� ����������, �� ������� �� �������
        if ($createResponse !== null
            && $createResponse->success === true
            && $createResponse->loyaltyAccount->active === false
            && $createResponse->loyaltyAccount->activatedAt === null
            && isset($createResponse->loyaltyAccount->id)
        ) {
            return [
                'msg' => GetMessage('GO_TO_PERSONAL'),
                'error' => false
            ];
        }

        if ($createResponse !== null && $createResponse->success === true) {
            //��������� ����������� ��������� �������
            return ['msg' => GetMessage('REG_COMPLETE'), 'error' => false];
        }

        return [];
    }

    /**
     * @return array
     */
    private function updateLoyaltyFieldsSettings(): array
    {
        /** @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter $client */
        $client = ClientFactory::createClientAdapter();
        $loyaltiesResponse = $client->getLoyaltyLoyalties();

        if ($loyaltiesResponse !== null && isset($loyaltiesResponse->loyalties[0])) {
            ConfigProvider::setLoyaltyProgramId($loyaltiesResponse->loyalties[0]->id);
            $loyalty = $client->getLoyaltyLoyalty((int)$loyaltiesResponse->loyalties[0]->id);

            if (null !== $loyalty) {
                $json = json_encode($loyalty->requiredFields);
                ConfigProvider::setLoyaltyFields($json);
            }
        }

        return (array)json_decode($json, true);
    }

    /**
     * @param array $requireFields
     * @param array $fieldSettings
     *
     * @return array
     */
    private function compareFields(array $requireFields, array $fieldSettings): array
    {
        return array_diff($requireFields, array_column($fieldSettings, 'code'));
    }

    /**
     * @param \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountActivateResponse $activateResponse
     *
     * @return array
     */
    private function checkErrors(LoyaltyAccountActivateResponse $activateResponse): array
    {
        if (
            count($activateResponse->errors) > 0
            && strpos(current($activateResponse->errors), GetMessage('LOYALTY_FIELD_ERROR')) !== false
        ) {
            return (array)explode(
                ', ',
                trim(str_replace(GetMessage('LOYALTY_FIELD_ERROR'), '', current($activateResponse->errors)))
            );
        }

        return [];
    }

    /**
     * @param array $requireFields
     * @param array $fieldSettings
     *
     * @return array
     */
    private function getRequireFieldsSettings(array $requireFields, array $fieldSettings): array
    {
        $resultFieldsArray = [];
        $codes = array_column($fieldSettings, 'code');

        $defaultFieldsCodes = ['Last name' => 'lastName', 'Email' => 'email', 'Phone number' => 'phoneNumber', 'First Name' => 'firstName'];

        foreach ($requireFields as $requireField) {
            if (isset($defaultFieldsCodes[$requireField])) {
                $requireField = $defaultFieldsCodes[$requireField];
            }

            $key = array_search($requireField, $codes, true);

            if ($key === false) {
                continue;
            }

            $resultFieldsArray[] = $fieldSettings[$key];
        }

        return $resultFieldsArray;
    }

    /**
     * @param \Intaro\RetailCrm\Model\Api\Response\Loyalty\Account\LoyaltyAccountCreateResponse|null $createResponse
     * 
     * @return bool
     */
    public function proveUserInLpExists(?LoyaltyAccountCreateResponse $createResponse): bool
    {
        if (
            $createResponse !== null
            && $createResponse->success !== true
            && isset($createResponse->errors)
            && isset(($createResponse->errors)['loyalty'])
            && ($createResponse->errors)['loyalty'] === 'The customer is in this loyalty program already'
        ) {
            $response = true;
        } else {
            $response = false;
        }

        return $response;
    }
}
