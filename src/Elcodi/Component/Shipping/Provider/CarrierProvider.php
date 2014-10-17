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
 */

namespace Elcodi\Component\Shipping\Provider;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Geo\Services\ZoneMatcher;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierPriceRangeInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierRangeInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierWeightRangeInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface;
use Elcodi\Component\Shipping\Repository\CarrierRepository;
use Elcodi\Component\Shipping\Repository\WarehouseRepository;

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
    )
    {
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
     * @return CarrierRangeInterface[] Set of carriers ranges satisfied
     */
    public function provideCarrierRangesSatisfiedWithOrder(OrderInterface $order)
    {
        $availableCarriers = $this
            ->carrierRepository
            ->findBy([
                'enabled' => true
            ]);

        $satisfiedCarriers = array();

        foreach ($availableCarriers as $carrier) {

            $carrierRange = $this->getCarrierRangeSatisfiedByOrder(
                $order,
                $carrier
            );

            if ($carrierRange instanceof CarrierRangeInterface) {

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
     * @return CarrierRangeInterface|false CarrierRange satisfied by Order
     */
    public function getCarrierRangeSatisfiedByOrder(
        OrderInterface $order,
        CarrierInterface $carrier
    )
    {
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
     * @param OrderInterface        $order
     * @param CarrierRangeInterface $carrierRange
     *
     * @return boolean Carrier Range is satisfied by order
     */
    public function isCarrierRangeSatisfiedByOrder(
        OrderInterface $order,
        CarrierRangeInterface $carrierRange
    )
    {
        if ($carrierRange instanceof CarrierPriceRangeInterface) {
            return $this->isCarrierPriceRangeSatisfiedByOrder($order, $carrierRange);
        } elseif ($carrierRange instanceof CarrierWeightRangeInterface) {
            return $this->isCarrierWeightRangeSatisfiedByOrder($order, $carrierRange);
        }

        return false;
    }

    /**
     * Given CarrierPriceRange is satisfied by a order
     *
     * @param OrderInterface             $order        Order
     * @param CarrierPriceRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isCarrierPriceRangeSatisfiedByOrder(
        OrderInterface $order,
        CarrierPriceRangeInterface $carrierRange
    )
    {
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
     * Given CarrierWeightRange is satisfied by a order
     *
     * @param OrderInterface              $order        Order
     * @param CarrierWeightRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isCarrierWeightRangeSatisfiedByOrder(
        OrderInterface $order,
        CarrierWeightRangeInterface $carrierRange
    )
    {
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
     * @param OrderInterface        $order        Order
     * @param CarrierRangeInterface $carrierRange Carrier Range
     *
     * @return bool CarrierRange is satisfied by order
     */
    public function isCarrierRangeZonesSatisfiedByOrder(
        OrderInterface $order,
        CarrierRangeInterface $carrierRange
    )
    {
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
                    $carrierRange->getFromZone(),
                    $warehouseAddress
                ) &&
            $this
                ->zoneMatcher
                ->isAddressContainedInZone(
                    $carrierRange->getToZone(),
                    $deliveryAddress
                );
    }
}
