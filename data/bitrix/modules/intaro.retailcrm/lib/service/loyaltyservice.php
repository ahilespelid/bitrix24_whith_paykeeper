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

use Bitrix\Main\Loader;
use Bitrix\Sale\BasketItemBase;
use Bitrix\Sale\Order;
use Exception;
use Intaro\RetailCrm\Component\ConfigProvider;
use Intaro\RetailCrm\Component\Constants;
use Intaro\RetailCrm\Component\Factory\ClientFactory;
use Intaro\RetailCrm\Component\ServiceLocator;
use Intaro\RetailCrm\Model\Api\LoyaltyAccount;
use Intaro\RetailCrm\Model\Api\LoyaltyAccountApiFilterType;
use Intaro\RetailCrm\Model\Api\OrderProduct;
use Intaro\RetailCrm\Model\Api\PriceType;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\Account\LoyaltyAccountRequest;
use Intaro\RetailCrm\Model\Api\Request\Loyalty\LoyaltyCalculateRequest;
use Intaro\RetailCrm\Model\Api\Request\Order\Loyalty\OrderLoyaltyApplyRequest;
use Intaro\RetailCrm\Model\Api\Response\Loyalty\LoyaltyCalculateResponse;
use Intaro\RetailCrm\Model\Api\Response\Order\Loyalty\OrderLoyaltyApplyResponse;
use Intaro\RetailCrm\Model\Api\SerializedOrder;
use Intaro\RetailCrm\Model\Api\SerializedOrderProduct;
use Intaro\RetailCrm\Model\Api\SerializedOrderProductOffer;
use Intaro\RetailCrm\Model\Api\SerializedOrderReference;
use Intaro\RetailCrm\Model\Api\SerializedRelationCustomer;
use Intaro\RetailCrm\Model\Bitrix\OrderLoyaltyData;
use Intaro\RetailCrm\Repository\CurrencyRepository;
use Intaro\RetailCrm\Repository\OrderLoyaltyDataRepository;
use Intaro\RetailCrm\Service\Exception\LpAccountsUnavailableException;
use Logger;

/**
 * Class LoyaltyService
 *
 * @package Intaro\RetailCrm\Service
 */
class LoyaltyService
{
    /**
     * @var \Intaro\RetailCrm\Component\ApiClient\ClientAdapter
     */
    private $client;

    /**
     * @var mixed
     */
    private $site;

    /**
     * @var \Logger
     */
    private $logger;

    /**
     * LoyaltyService constructor.
     *
     * @throws \Bitrix\Main\LoaderException
     */
    public function __construct()
    {
        IncludeModuleLangFile(__FILE__);

        $this->logger = Logger::getInstance();
        $this->client = ClientFactory::createClientAdapter();
        $this->site = ConfigProvider::getSitesAvailable();

        Loader::includeModule('Catalog');
    }

    /**
     * ��������� ������ �� ���������� ������� �� ��������� ����������
     *
     * @link https://docs.retailcrm.ru/Developers/API/APIVersions/APIv5#post--api-v5-orders-loyalty-apply
     *
     * @param int   $orderId    ID ������
     * @param float $bonusCount ���������� ������� ��� ��������
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Order\Loyalty\OrderLoyaltyApplyResponse|mixed|null
     */
    public function sendBonusPayment(int $orderId, float $bonusCount): ?OrderLoyaltyApplyResponse
    {
        $request = new OrderLoyaltyApplyRequest();
        $request->order = new SerializedOrderReference();
        $request->order->externalId = $orderId;
        $request->bonuses = $bonusCount;
        $request->site = $this->site;
        $result = $this->client->loyaltyOrderApply($request);

        Utils::handleApiErrors($result);

        return $result;
    }

    /**
     * ���������� ������ ���������� �� ������ ������� � ���������� ������� ��� ��������
     *
     * @link https://docs.retailcrm.ru/Developers/API/APIVersions/APIv5#post--api-v5-loyalty-calculate
     *
     * @param array $basketItems �������
     * @param float $bonuses ���������� ������� ��� ��������
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Loyalty\LoyaltyCalculateResponse|mixed|null
     */
    public function getLoyaltyCalculate(array $basketItems, float $bonuses = 0): ?LoyaltyCalculateResponse
    {
        global $USER;

        $request = new LoyaltyCalculateRequest();
        $request->order = new SerializedOrder();
        $request->order->customer = new SerializedRelationCustomer();
        $request->order->customer->id = $USER->GetID();
        $request->order->customer->externalId = $USER->GetID();

        $request->site = $this->site;
        $request->bonuses = $bonuses;

        foreach ($basketItems as $item) {
            $product = new SerializedOrderProduct();

            $fullPrice = $item['BASE_PRICE'] ?? $item['FULL_PRICE'];
            $product->initialPrice = $fullPrice; //���� ��� ������

            if ($fullPrice > 0) {
                $product->discountManualAmount = $fullPrice - $item['PRICE'];
            }

            $product->offer = new SerializedOrderProductOffer();
            $product->offer->externalId = $item['ID'];
            $product->offer->id = $item['ID'];
            $product->offer->xmlId = $item['XML_ID'];
            $product->quantity = $item['QUANTITY'];

            $prices = ConfigProvider::getCrmPrices();
            $product->priceType = new PriceType();
            $serializePrice = unserialize($prices);

            if (isset($serializePrice[$item['PRICE_TYPE_ID']])) {
                $product->priceType->code = $serializePrice[$item['PRICE_TYPE_ID']];
            }

            $request->order->items[] = $product;
        }

        $result = $this->client->loyaltyCalculate($request);

        if (isset($result->errorMsg) && !empty($result->errorMsg)) {
            $this->logger->write($result->errorMsg, Constants::LOYALTY_ERROR);
        }

        return $result;
    }

    //TODO �������� ����� �������� ����������� � ��

    /**
     * ���������� ������ ������� � ��������� ����������
     *
     * @link https://docs.retailcrm.ru/Developers/API/APIVersions/APIv5#get--api-v5-loyalty-accounts
     *
     * @param int $idInLoyalty ID ������� � ��������� ����������
     *
     * @return null|\Intaro\RetailCrm\Model\Api\LoyaltyAccount
     * @throws \Intaro\RetailCrm\Service\Exception\LpAccountsUnavailableException
     */
    public function getLoyaltyAccounts(int $idInLoyalty): ?LoyaltyAccount
    {
        $request = new LoyaltyAccountRequest();
        $request->filter = new LoyaltyAccountApiFilterType();
        $request->filter->id = $idInLoyalty;
        $request->filter->sites = is_array($this->site) ? $this->site : [$this->site];

        $response = $this->client->getLoyaltyAccounts($request);

        if ($response !== null && $response->success) {
            if (!isset($response->loyaltyAccounts[0])) {
                throw new LpAccountsUnavailableException();
            }

            return $response->loyaltyAccounts[0];
        }

        Utils::handleApiErrors($response);

        return null;
    }

    /**
     * �������� ���������� �������� ������
     *
     * ������������ ��� ������������� ��� ��� ��������� ���
     *
     * @param int $orderId
     *
     * @return \Intaro\RetailCrm\Model\Bitrix\SmsCookie|bool
     */
    public function resendBonusPayment(int $orderId)
    {
        /** @var CookieService $service */
        $service = ServiceLocator::get(CookieService::class);
        $bonusCount = $this->getTotalBonusCount($orderId);

        if ($bonusCount === false || $bonusCount === 0) {
            return false;
        }

        /** @var  OrderLoyaltyApplyResponse $response */
        $response = $this->sendBonusPayment($orderId, $bonusCount);

        if ($response === null || !($response instanceof OrderLoyaltyApplyResponse)) {
            return false;
        }

        if (
            isset($response->verification, $response->verification->checkId)
            && empty($response->verification->verifiedAt)
        ) {
            return $service->setSmsCookie('lpOrderBonusConfirm', $response->verification);
        }

        if (!empty($response->verification->verifiedAt)) {
            $this->saveBonusDiscounts(Order::load($orderId), $response);
            $this->setDebitedStatus($orderId, true);

            return true;
        }

        return false;
    }

    /**
     * @param int  $orderId
     * @param bool $newStatus
     */
    public function setDebitedStatus(int $orderId, bool $newStatus): void
    {
        $repository = new OrderLoyaltyDataRepository();
        $products = $repository->getProductsByOrderId($orderId);

        if (is_array($products)) {
            /** @var OrderLoyaltyData $product */
            foreach ($products as $product) {
                $product->isDebited = $newStatus;
                $repository->edit($product);
            }
        }
    }

    /**
     * ��������� ������ � ��������� ����������  � ������ �������
     *
     * @param array                                                                 $basketData
     * @param \Intaro\RetailCrm\Model\Api\Response\Loyalty\LoyaltyCalculateResponse $calculate
     *
     * @return array
     */
    public function addLoyaltyToBasket(array $basketData, LoyaltyCalculateResponse $calculate): array
    {
        $totalRenderData = &$basketData['TOTAL_RENDER_DATA'];
        $basketData['LP_CALCULATE_SUCCESS'] = $calculate->success;
        $totalRenderData['WILL_BE_CREDITED'] = $calculate->order->bonusesCreditTotal;

        foreach ($calculate->calculations as $privilege) {
            if ($privilege->maximum && $privilege->creditBonuses === 0.0) {
                $totalRenderData['LOYALTY_DISCOUNT']
                    = round($privilege->discount - $basketData['DISCOUNT_PRICE_ALL'], 2);
                $totalRenderData['LOYALTY_DISCOUNT_FORMATED'] = $totalRenderData['LOYALTY_DISCOUNT']
                    . ' ' . GetMessage($totalRenderData['CURRENCY']);
                $totalRenderData['PRICE'] -= $totalRenderData['LOYALTY_DISCOUNT'];//����� ����� �� �������
                $totalRenderData['PRICE_FORMATED'] = $totalRenderData['PRICE']
                    . ' ' . GetMessage($totalRenderData['CURRENCY']); //����������������� ����� �� �������
                $totalRenderData['SUM_WITHOUT_VAT_FORMATED'] = $totalRenderData['PRICE_FORMATED'];
                $basketData['allSum_FORMATED'] = $totalRenderData['PRICE_FORMATED'];
                $basketData['allSum_wVAT_FORMATED'] = $totalRenderData['PRICE_FORMATED'];
                $basketData['allSum'] = $totalRenderData['PRICE'];
                $totalRenderData['DISCOUNT_PRICE_FORMATED'] = $privilege->discount
                    . ' ' . GetMessage($totalRenderData['CURRENCY']);
                $totalRenderData['LOYALTY_DISCOUNT_DEFAULT'] = $basketData['DISCOUNT_PRICE_ALL']
                    . ' ' . GetMessage($totalRenderData['CURRENCY']);
            }
        }

        foreach ($basketData['BASKET_ITEM_RENDER_DATA'] as $key => &$item) {
            $item['WILL_BE_CREDITED_BONUS'] = $calculate->order->items[$key]->bonusesCreditTotal;

            if ($calculate->order->items[$key]->bonusesCreditTotal === 0.0) {
                $item['PRICE'] -= $calculate->order->items[$key]->discountTotal
                    - ($item['SUM_DISCOUNT_PRICE'] / $item['QUANTITY']);
                $item['SUM_PRICE'] = $item['PRICE'] * $item['QUANTITY'];
                $item['PRICE_FORMATED'] = $item['PRICE'] . ' ' . GetMessage($item['CURRENCY']);
                $item['SUM_PRICE_FORMATED'] = $item['SUM_PRICE'] . ' ' . GetMessage($item['CURRENCY']);
                $item['SHOW_DISCOUNT_PRICE'] = true;
                $item['SUM_DISCOUNT_PRICE'] = $calculate->order->items[$key]->discountTotal
                    * $item['QUANTITY'];
                $item['SUM_DISCOUNT_PRICE_FORMATED'] = $item['SUM_DISCOUNT_PRICE']
                    . ' '
                    . GetMessage($item['CURRENCY']);
                $item['DISCOUNT_PRICE_PERCENT'] = round($item['SUM_DISCOUNT_PRICE']
                    / (($item['FULL_PRICE'] * $item['QUANTITY']) / 100));
                $item['DISCOUNT_PRICE_PERCENT_FORMATED'] = $item['DISCOUNT_PRICE_PERCENT'] . '%';

                if (isset($item['COLUMN_LIST'])) {
                    foreach ($item['COLUMN_LIST'] as &$column) {
                        $column['VALUE'] = $column['CODE'] === 'DISCOUNT'
                            ? $item['DISCOUNT_PRICE_PERCENT_FORMATED'] : $column['VALUE'];
                    }

                    unset($column);
                }
            }
        }

        unset($item);

        return $basketData;
    }

    /**
     * @param array                                                                 $orderArResult
     * @param \Intaro\RetailCrm\Model\Api\Response\Loyalty\LoyaltyCalculateResponse $calculate
     *
     * @return array
     */
    public function calculateOrderBasket(array $orderArResult, LoyaltyCalculateResponse $calculate): array
    {
        /** @var \Intaro\RetailCrm\Model\Api\LoyaltyCalculation $privilege */
        foreach ($calculate->calculations as $privilege) {
            if ($privilege->maximum) {
                $orderArResult['AVAILABLE_BONUSES'] = $privilege->maxChargeBonuses;

                $jsDataTotal = &$orderArResult['JS_DATA']['TOTAL'];

                //���� ������� ���������
                if ($privilege->maximum && $privilege->discount > 0) {
                    //������������ ������
                    $jsDataTotal['LOYALTY_DISCOUNT'] = $orderArResult['LOYALTY_DISCOUNT_INPUT']
                        = round($privilege->discount - $jsDataTotal['DISCOUNT_PRICE'], 2);

                    //����� ���������
                    $jsDataTotal['ORDER_TOTAL_PRICE'] -= $jsDataTotal['LOYALTY_DISCOUNT'];

                    //������� ������
                    $jsDataTotal['DEFAULT_DISCOUNT'] = $jsDataTotal['DISCOUNT_PRICE'];

                    $jsDataTotal['ORDER_TOTAL_PRICE_FORMATED'] = round($jsDataTotal['ORDER_TOTAL_PRICE'], 2)
                        . ' ' . GetMessage($orderArResult['BASE_LANG_CURRENCY']);

                    $jsDataTotal['DISCOUNT_PRICE'] += $jsDataTotal['LOYALTY_DISCOUNT'];

                    $jsDataTotal['DISCOUNT_PRICE_FORMATED'] = $jsDataTotal['DISCOUNT_PRICE']
                        . ' ' . GetMessage($orderArResult['BASE_LANG_CURRENCY']);

                    $jsDataTotal['ORDER_PRICE'] -= $jsDataTotal['LOYALTY_DISCOUNT'];

                    $jsDataTotal['ORDER_PRICE_FORMATED'] = $jsDataTotal['ORDER_PRICE']
                        . ' ' . GetMessage($orderArResult['BASE_LANG_CURRENCY']);

                    $iterator = 0;

                    foreach ($orderArResult['JS_DATA']['GRID']['ROWS'] as $key => &$item) {
                        $item['data']['SUM_NUM'] = $orderArResult['CALCULATE_ITEMS_INPUT'][$key]['SUM_NUM']
                            = $item['data']['SUM_BASE']
                            - ($calculate->order->items[$iterator]->discountTotal
                                * $item['data']['QUANTITY']);

                        $orderArResult['CALCULATE_ITEMS_INPUT'][$key]['QUANTITY'] = $item['data']['QUANTITY'];
                        $orderArResult['CALCULATE_ITEMS_INPUT'][$key]['SHOP_ITEM_DISCOUNT']
                            = round($item['data']['BASE_PRICE'] - $item['data']['PRICE'], 2);
                        $orderArResult['CALCULATE_ITEMS_INPUT'][$key]['BASE_PRICE']
                            = $item['data']['BASE_PRICE'];

                        $item['data']['SUM'] = $item['data']['SUM_NUM']
                            . ' ' . GetMessage($orderArResult['BASE_LANG_CURRENCY']);

                        $item['data']['DISCOUNT_PRICE'] = $calculate->order->items[$iterator]->discountTotal;

                        $iterator++;
                    }

                    unset($item);

                    $orderArResult['CALCULATE_ITEMS_INPUT']
                        = htmlspecialchars(json_encode($orderArResult['CALCULATE_ITEMS_INPUT']));
                }

                break;
            }
        }

        $orderArResult['CHARGERATE'] = $calculate->loyalty->chargeRate;
        $orderArResult['TOTAL_BONUSES_COUNT'] = $calculate->order->loyaltyAccount->amount;
        $orderArResult['LP_CALCULATE_SUCCESS'] = $calculate->success;
        $orderArResult['WILL_BE_CREDITED'] = $calculate->order->bonusesCreditTotal;

        $currencyRepository = new CurrencyRepository();
        $orderArResult['BONUS_CURRENCY'] = html_entity_decode($currencyRepository->getCurrencyFormatString());

        return $orderArResult;
    }

    /**
     * @param \Bitrix\Sale\Order $order
     * @param array              $calculateItemsInput
     */
    public function saveDiscounts(Order $order, array $calculateItemsInput): void
    {
        try {
            /** @var BasketItemBase $basketItem */
            foreach ($order->getBasket() as $basketItem) {
                $calcItemPosition = $calculateItemsInput[$basketItem->getId()];
                $calculateItem = $calcItemPosition['SUM_NUM'] / $calcItemPosition['QUANTITY'];

                $basketItem->setField('CUSTOM_PRICE', 'Y');
                $basketItem->setField('DISCOUNT_PRICE', $basketItem->getBasePrice() - $calculateItem);
                $basketItem->setField('PRICE', $calculateItem);
            }

            $order->save();
        } catch (Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }
    }


    /**
     * @param \Bitrix\Sale\Order                                                           $order
     * @param \Intaro\RetailCrm\Model\Api\Response\Order\Loyalty\OrderLoyaltyApplyResponse $response
     *
     * @return void|null
     */
    public function saveBonusDiscounts(Order $order, OrderLoyaltyApplyResponse $response): void
    {
        try {
            $basketItems = $order->getBasket();

            if ($basketItems === null) {
                $this->logger->write('No item in basket', Constants::LOYALTY_ERROR);
            }

            /** @var BasketItemBase $basketItem */
            foreach ($basketItems as $key => $basketItem) {
                /** @var OrderProduct $item */
                $item = $response->order->items[$key];
                $basePrice = $basketItem->getField('BASE_PRICE');
                $basketItem->setField('CUSTOM_PRICE', 'Y');
                $basketItem->setField('DISCOUNT_PRICE', $item->discountTotal);
                $basketItem->setField('PRICE', $basePrice - $item->discountTotal);
            }

            $order->save();
        } catch (Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }
    }

    /**
     * @param int $externalId
     *
     * @return float|null
     */
    public function getInitialDiscount(int $externalId): ?float
    {
        $repository = new OrderLoyaltyDataRepository();

        return $repository->getDefDiscountByProductPosition($externalId);
    }

    /**
     * ������� �� ������ � ������
     *
     * @param $orderId
     *
     * @return bool|null
     */
    public function isBonusDebited($orderId): ?bool
    {
        $repository = new OrderLoyaltyDataRepository();
        $products = $repository->getProductsByOrderId($orderId);

        if ($products === null || count($products) === 0) {
            return null;
        }

        foreach ($products as $product) {
            if (!empty($product->checkId) && $product->isDebited === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * ��������� ������ �������� � ����� ������� (������������� ��������� ����)
     *
     * @param \Bitrix\Sale\Order $order
     * @param float              $bonusCount /�������� ������ � ������
     *
     * @return \Intaro\RetailCrm\Model\Api\Response\Order\Loyalty\OrderLoyaltyApplyResponse|null
     */
    public function applyBonusesInOrder(Order $order, float $bonusCount): ?OrderLoyaltyApplyResponse
    {
        $response = $this->sendBonusPayment($order->getId(), $bonusCount);

        if ($response->success) {
           $this->saveBonusDiscounts($order, $response);
        } else {
            Utils::handleApiErrors($response);
            return null;
        }

        return $response;
    }

    /**
     * @param $orderId
     *
     * @return int|null
     */
    private function getTotalBonusCount($orderId): ?int
    {
        $repository = new OrderLoyaltyDataRepository();
        $products = $repository->getProductsByOrderId($orderId);

        if ($products === null || count($products) === 0) {
            return null;
        }

        foreach ($products as $product) {
            if ($product->bonusCountTotal > 0) {
                return $product->bonusCountTotal;
            }
        }

        return null;
    }
}
