<?php

/**
 * @category Integration
 * @package  Intaro\RetailCrm\Repository
 * @author   RetailCRM <integration@retailcrm.ru>
 * @license  MIT
 * @link     http://retailcrm.ru
 * @see      http://retailcrm.ru/docs
 */

namespace Intaro\RetailCrm\Repository;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Exception;
use Intaro\RetailCrm\Component\Constants;
use Intaro\RetailCrm\Component\Json\Deserializer;
use Intaro\RetailCrm\Component\Json\Serializer;
use Intaro\RetailCrm\Model\Bitrix\OrderLoyaltyData;
use Intaro\RetailCrm\Service\Utils;
use Logger;

/**
 * Class OrderLoyaltyDataRepository
 *
 * @package Intaro\RetailCrm\Repository
 */
class OrderLoyaltyDataRepository extends AbstractRepository
{
    /**
     * @var \Bitrix\Main\Entity\DataManager|string|null
     */
    private $dataManager;

    /**
     * @var \Logger
     */
    private $logger;

    /**
     * OrderLoyaltyDataRepository constructor.
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\SystemException
     */
    public function __construct()
    {
        $this->logger = Logger::getInstance();
        $this->dataManager = Utils::getHlClassByName(Constants::HL_LOYALTY_CODE);
    }

    /**
     * @param \Intaro\RetailCrm\Model\Bitrix\OrderLoyaltyData $loyaltyHl
     * @return int|null
     */
    public function add(OrderLoyaltyData $loyaltyHl): ?int
    {
        try {
            if ($this->dataManager === null) {
                return null;
            }

            $result = Serializer::serializeArray($loyaltyHl, OrderLoyaltyData::class);

            unset($result['ID']);

            $result = $this->dataManager::add($result);

            if ($result->isSuccess()) {
                return $result->getId();
            }

            return null;
        } catch (Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }

        return null;
    }

    /**
     * @param int $positionId
     * @return \Intaro\RetailCrm\Model\Bitrix\OrderLoyaltyData|null
     */
    public function getOrderLpDataByPosition(int $positionId): ?OrderLoyaltyData
    {
        if ($this->dataManager === null) {
            return null;
        }

        try {
            $product = $this->dataManager::query()
                ->setSelect(['*'])
                ->where('UF_ITEM_POS_ID', '=', $positionId)
                ->fetch();

            if (false === $product) {
                return null;
            }

            return Deserializer::deserializeArray($product, OrderLoyaltyData::class);
        } catch (ObjectPropertyException | ArgumentException | SystemException $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }
    }

    /**
     * @param $orderId
     *
     * @return OrderLoyaltyData[]
     */
    public function getProductsByOrderId($orderId): array
    {
        $products = $this->getHlRowByOrderId($orderId);

        if (count($products) === 0 || false === $products) {
            return [];
        }

        $result = [];

        foreach ($products as $product) {
            $result[$product['UF_ITEM_POS_ID']]
                = Deserializer::deserializeArray($product, OrderLoyaltyData::class);
        }

        return $result;
    }

    /**
     * @param int $orderId
     *
     * @return array|false //fetchAll ����� ������� false
     */
    private function getHlRowByOrderId(int $orderId)
    {
        try {
            if ($this->dataManager === null) {
                return [];
            }

            return $this->dataManager::query()
                ->setSelect(['*'])
                ->where('UF_ORDER_ID', '=', $orderId)
                ->fetchAll();

        } catch (SystemException | Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }

        return [];
    }

    /**
     * @param \Intaro\RetailCrm\Model\Bitrix\OrderLoyaltyData $position
     * @return bool
     */
    public function edit(OrderLoyaltyData $position): bool
    {
        try {
            if ($this->dataManager === null) {
                return false;
            }

            $productAr = Serializer::serializeArray($position, OrderLoyaltyData::class);

            unset($productAr['ID']);

            foreach ($productAr as $key => $value) {
                if (null === $value) {
                    unset($productAr[$key]);
                }
            }

            $result = $this->dataManager::update($position->id, $productAr);

            if ($result->isSuccess()) {
                return true;
            }

        } catch (Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }

        return false;
    }

    /**
     * @param mixed $primary
     * @return bool
     */
    public function delete($primary): bool
    {
        try {
            if ($this->dataManager === null) {
                return false;
            }

            $result = $this->dataManager::delete($primary);

            if ($result->isSuccess()) {
                return true;
            }

        } catch (Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }

        return false;

    }

    /**
     * @param int $externalId
     * @return float|null
     */
    public function getDefDiscountByProductPosition(int $externalId): ?float
    {
        try {
            if ($this->dataManager === null) {
                return null;
            }

            $result = $this->dataManager::query()
                ->setSelect(['UF_DEF_DISCOUNT'])
                ->where([
                    ['UF_ITEM_POS_ID', '=', $externalId]
                ])
                ->fetch();

            if ($result !== false) {
                return (float) $result['UF_DEF_DISCOUNT'];
            }
        } catch (SystemException | Exception $exception) {
            $this->logger->write($exception->getMessage(), Constants::LOYALTY_ERROR);
        }

        return null;
    }
}
