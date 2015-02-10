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
use Elcodi\Component\Shipping\Resolver\CarrierResolver;

/**
 * Class ShippingProvider
 */
class ShippingProvider
{
    /**
     * @var CarrierProvider
     *
     * Carrier Provider
     */
    protected $carrierProvider;

    /**
     * @var CarrierResolver
     *
     * Carrier Resolver
     */
    protected $carrierResolver;

    /**
     * Construct method
     *
     * @param CarrierProvider $carrierProvider Carrier Provider
     * @param CarrierResolver $carrierResolver Carrier Resolver
     */
    public function __construct(
        CarrierProvider $carrierProvider,
        CarrierResolver $carrierResolver
    )
    {
        $this->carrierProvider = $carrierProvider;
        $this->carrierResolver = $carrierResolver;
    }

    /**
     * Return all valid CarrierRanges satisfied by a Cart
     *
     * @param OrderInterface $order Order
     *
     * @return array Valid CarrierRanges satisfied by the cart
     */
    public function getValidCarrierRangesFromCart(OrderInterface $order)
    {
        $carrierRanges = $this->getAllCarrierRangesFromOrder($order);

        return $this
            ->carrierResolver
            ->resolveCarrierRanges($carrierRanges);
    }

    /**
     * Return all CarrierRanges satisfied by a Order
     *
     * @param OrderInterface $order Order
     *
     * @return array CarrierRanges satisfied by the cart
     */
    public function getAllCarrierRangesFromOrder(OrderInterface $order)
    {
        return $this
            ->carrierProvider
            ->provideCarrierRangesSatisfiedWithOrder($order);
    }
}
