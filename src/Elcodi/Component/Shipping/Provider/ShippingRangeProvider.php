<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;
use Elcodi\Component\Shipping\Repository\CarrierRepository;
use Elcodi\Component\Shipping\Resolver\ShippingRangeResolver;
use Elcodi\Component\Zone\Services\ZoneMatcher;

/**
 * Class ShippingRangeProvider
 */
class ShippingRangeProvider
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
     * @var ZoneMatcher
     *
     * ZoneMatcher
     */
    protected $zoneMatcher;

    /**
     * @var ShippingRangeResolver
     *
     * Carrier Resolver
     */
    protected $shippingRangeResolver;

    /**
     * Construct method
     *
     * @param CarrierRepository     $carrierRepository     Carrier Repository
     * @param CurrencyConverter     $currencyConverter     Currency Converter
     * @param ZoneMatcher           $zoneMatcher           Zone matcher
     * @param ShippingRangeResolver $shippingRangeResolver Carrier Resolver
     */
    public function __construct(
        CarrierRepository $carrierRepository,
        CurrencyConverter $currencyConverter,
        ZoneMatcher $zoneMatcher,
        ShippingRangeResolver $shippingRangeResolver
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->currencyConverter = $currencyConverter;
        $this->zoneMatcher = $zoneMatcher;
        $this->shippingRangeResolver = $shippingRangeResolver;
    }

    /**
     * Given a Cart, return a set of Valid ShippingRanges satisfied.
     *
     * @param CartInterface $cart Cart
     *
     * @return ShippingRangeInterface[] Set of valid carriers ranges satisfied
     */
    public function getValidShippingRangesSatisfiedWithCart(CartInterface $cart)
    {
        $carrierRanges = $this->getAllShippingRangesSatisfiedWithCart($cart);

        return $this
            ->shippingRangeResolver
            ->resolveShippingRanges($carrierRanges);
    }

    /**
     * Given a Cart, return a set of ShippingRanges satisfied.
     *
     * @param CartInterface $cart Cart
     *
     * @return ShippingRangeInterface[] Set of carriers ranges satisfied
     */
    public function getAllShippingRangesSatisfiedWithCart(CartInterface $cart)
    {
        $availableCarriers = $this
            ->carrierRepository
            ->findBy([
                'enabled' => true,
            ]);

        $satisfiedCarriers = [];

        foreach ($availableCarriers as $carrier) {
            $shippingRange = $this->getShippingRangeSatisfiedByCart(
                $cart,
                $carrier
            );

            if ($shippingRange instanceof ShippingRangeInterface) {
                $satisfiedCarriers[$shippingRange->getId()] = $shippingRange;
            }
        }

        return $satisfiedCarriers;
    }

    /**
     * Return the first Carrier's ShippingRange satisfied by a Cart.
     *
     * If none is found, return false
     *
     * @param CartInterface    $cart
     * @param CarrierInterface $carrier
     *
     * @return ShippingRangeInterface|false ShippingRange satisfied by Cart
     */
    public function getShippingRangeSatisfiedByCart(
        CartInterface $cart,
        CarrierInterface $carrier
    ) {
        $shippingRanges = $carrier->getRanges();

        foreach ($shippingRanges as $shippingRange) {
            $shippingRangeSatisfied = $this->isShippingRangeSatisfiedByCart(
                $cart,
                $shippingRange
            );

            if ($shippingRangeSatisfied) {
                return $shippingRange;
            }
        }

        return false;
    }

    /**
     * Return if Carrier Range is satisfied by cart
     *
     * @param CartInterface          $cart
     * @param ShippingRangeInterface $shippingRange
     *
     * @return boolean Carrier Range is satisfied by cart
     */
    public function isShippingRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        if ($shippingRange->getType() === ElcodiShippingRangeTypes::TYPE_PRICE) {
            return $this->isShippingPriceRangeSatisfiedByCart($cart, $shippingRange);
        } elseif ($shippingRange->getType() === ElcodiShippingRangeTypes::TYPE_WEIGHT) {
            return $this->isShippingWeightRangeSatisfiedByCart($cart, $shippingRange);
        }

        return false;
    }

    /**
     * Given ShippingPriceRange is satisfied by a cart
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    public function isShippingPriceRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $cartPrice = $cart->getProductAmount();
        $cartPriceCurrency = $cartPrice->getCurrency();
        $shippingRangeFromPrice = $shippingRange->getFromPrice();
        $shippingRangeToPrice = $shippingRange->getToPrice();

        return
            $this->isShippingRangeZonesSatisfiedByCart($cart, $shippingRange) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($shippingRangeFromPrice, $cartPriceCurrency)
                    ->compareTo($cartPrice) <= 0
            ) &&
            (
                $this
                    ->currencyConverter
                    ->convertMoney($shippingRangeToPrice, $cartPriceCurrency)
                    ->compareTo($cartPrice) > 0
            );
    }

    /**
     * Given ShippingWeightRange is satisfied by a cart
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    public function isShippingWeightRangeSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $cartWeight = $cart->getWeight();
        $cartRangeFromWeight = $shippingRange->getFromWeight();
        $cartRangeToWeight = $shippingRange->getToWeight();

        return
            $this->isShippingRangeZonesSatisfiedByCart($cart, $shippingRange) &&
            is_numeric($cartRangeFromWeight) &&
            is_numeric($cartRangeToWeight) &&
            $cartRangeFromWeight >= 0 &&
            $cartRangeToWeight >= 0 &&
            $cartWeight >= $cartRangeFromWeight &&
            $cartWeight < $cartRangeToWeight;
    }

    /**
     * Given ShippingRange zones are satisfied by a cart,
     *
     * @param CartInterface          $cart          Cart
     * @param ShippingRangeInterface $shippingRange Carrier Range
     *
     * @return boolean ShippingRange is satisfied by cart
     */
    public function isShippingRangeZonesSatisfiedByCart(
        CartInterface $cart,
        ShippingRangeInterface $shippingRange
    ) {
        $deliveryAddress = $cart->getDeliveryAddress();

        return
            $deliveryAddress === null ||
            $this
                ->zoneMatcher
                ->isAddressContainedInZone(
                    $deliveryAddress,
                    $shippingRange->getToZone()
                );
    }
}
