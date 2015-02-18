<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Shipping\Provider;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface;
use Elcodi\Component\Shipping\Repository\CarrierRepository;
use Elcodi\Component\Shipping\Repository\WarehouseRepository;
use Elcodi\Component\Zone\Services\ZoneMatcher;

/**
 * Class CarrierProvider
 */
class CarrierProvider
{
    /**
     * @var CarrierRepository
     *
     * carrierRepository
     */
    protected $carrierRepository;

    /**
     * @var CurrencyConverter
     *
     * currencyConverter
     */
    protected $currencyConverter;

    /**
     * @var WarehouseRepository
     *
     * warehouse repository
     */
    protected $warehouseRepository;

    /**
     * @var ZoneMatcher
     *
     * ZoneMatcher
     */
    protected $zoneMatcher;

    /**
     * Construct method
     *
     * @param CarrierRepository   $carrierRepository   Carrier Repository
     * @param CurrencyConverter   $currencyConverter   Currency Converter
     * @param WarehouseRepository $warehouseRepository Warehouse repository
     * @param ZoneMatcher         $zoneMatcher         Zone matcher
     */
    public function __construct(
        CarrierRepository $carrierRepository,
        CurrencyConverter $currencyConverter,
        WarehouseRepository $warehouseRepository,
        ZoneMatcher $zoneMatcher
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->currencyConverter = $currencyConverter;
        $this->warehouseRepository = $warehouseRepository;
        $this->zoneMatcher = $zoneMatcher;
    }

    /**
     * Given a Order, return a set of CarrierRanges satisfied.
     *
     * @param OrderInterface $order Order
     *
     * @return ShippingRangeInterface[] Set of carriers ranges satisfied
     */
    public function provideCarrierRangesSatisfiedWithOrder(OrderInterface $order)
    {
        $availableCarriers = $this
            ->carrierRepository
            ->findBy([
                'enabled' => true,
            ]);

        $satisfiedCarriers = array();

        foreach ($availableCarriers as $carrier) {
            $carrierRange = $this->getCarrierRangeSatisfiedByOrder(
                $order,
                $carrier
            );

            if ($carrierRange instanceof ShippingRangeInterface) {
                $satisfiedCarriers[] = $carrierRange;
            }
        }

        return $satisfiedCarriers;
    }

    /**
     * Return the first Carrier's CarrierRange satisfied by a Order.
     *
     * If none is found, return false
     *
     * @param OrderInterface   $order
     * @param CarrierInterface $carrier
     *
     * @return ShippingRangeInterface|false CarrierRange satisfied by Order
     */
    public function getCarrierRangeSatisfiedByOrder(
        OrderInterface $order,
        CarrierInterface $carrier
    ) {
        $carrierRanges = $carrier->getRanges();

        foreach ($carrierRanges as $carrierRange) {
            $carrierRangeSatisfied = $this->isCarrierRangeSatisfiedByOrder(
                $order,
                $carrierRange
            );

            if ($carrierRangeSatisfied) {
                return $carrierRange;
            }
        }

        return false;
    }

    /**
     * Return if Carrier Range is satisfied by order
     *
     * @param OrderInterface         $order
     * @param ShippingRangeInterface $carrierRange
     *
     * @return boolean Carrier Range is satisfied by order
     */
    public function isCarrierRangeSatisfiedByOrder(
        OrderInterface $order,
        ShippingRangeInterface $carrierRange
    ) {
        if ($carrierRange->getType() === ElcodiShippingRangeTypes::TYPE_PRICE) {
            return $this->isShippingPriceRangeSatisfiedByOrder($order, $carrierRange);
        } elseif ($carrierRange->getType() === ElcodiShippingRangeTypes::TYPE_WEIGHT) {
            return $this->isShippingWeightRangeSatisfiedByOrder($order, $carrierRange);
        }

        return false;
    }

    /**
     * Given ShippingPriceRange is satisfied by a order
     *
     * @param OrderInterface         $order        Order
     * @param ShippingRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isShippingPriceRangeSatisfiedByOrder(
        OrderInterface $order,
        ShippingRangeInterface $carrierRange
    ) {
        $orderPrice = $order->getAmount();
        $orderPriceCurrency = $orderPrice->getCurrency();
        $carrierRangeFromPrice = $carrierRange->getFromPrice();
        $carrierRangeToPrice = $carrierRange->getToPrice();

        return
            $this->isCarrierRangeZonesSatisfiedByOrder($order, $carrierRange) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($carrierRangeFromPrice, $orderPriceCurrency)
                    ->compareTo($orderPrice) <= 0
            ) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($carrierRangeToPrice, $orderPriceCurrency)
                    ->compareTo($orderPrice) > 0
            );
    }

    /**
     * Given ShippingWeightRange is satisfied by a order
     *
     * @param OrderInterface         $order        Order
     * @param ShippingRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isShippingWeightRangeSatisfiedByOrder(
        OrderInterface $order,
        ShippingRangeInterface $carrierRange
    ) {
        $orderWeight = $order->getWeight();
        $orderRangeFromWeight = $carrierRange->getFromWeight();
        $orderRangeToWeight = $carrierRange->getToWeight();

        return
            $this->isCarrierRangeZonesSatisfiedByOrder($order, $carrierRange) &&
            is_numeric($orderRangeFromWeight) &&
            is_numeric($orderRangeToWeight) &&
            $orderRangeFromWeight >= 0 &&
            $orderRangeToWeight >= 0 &&
            $orderWeight >= $orderRangeFromWeight &&
            $orderWeight < $orderRangeToWeight;
    }

    /**
     * Given CarrierRange zones are satisfied by a order, using as a warehouse
     * the first valid warehouse available
     *
     * @param OrderInterface         $order        Order
     * @param ShippingRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isCarrierRangeZonesSatisfiedByOrder(
        OrderInterface $order,
        ShippingRangeInterface $carrierRange
    ) {
        $warehouse = $this
            ->warehouseRepository
            ->findOneBy([
                'enabled' => true,
            ]);

        if (!($warehouse instanceof WarehouseInterface)) {
            return false;
        }

        $warehouseAddress = $warehouse->getAddress();
        if (!($warehouseAddress instanceof AddressInterface)) {
            return false;
        }

        $deliveryAddress = $order->getDeliveryAddress();

        return
            $this
                ->zoneMatcher
                ->isAddressContainedInZone(
                    $warehouseAddress,
                    $carrierRange->getFromZone()
                ) &&
            $this
                ->zoneMatcher
                ->isAddressContainedInZone(
                    $deliveryAddress,
                    $carrierRange->getToZone()
                );
    }
}
