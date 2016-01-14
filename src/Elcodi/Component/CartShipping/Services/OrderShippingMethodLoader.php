<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\CartShipping\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;

/**
 * Class OrderShippingMethodLoader.
 */
class OrderShippingMethodLoader
{
    /**
     * @var ShippingWrapper
     *
     * Shipping wrapper
     */
    private $shippingWrapper;

    /**
     * Construct.
     *
     * @param ShippingWrapper $shippingWrapper Shipping wrapper
     */
    public function __construct(ShippingWrapper $shippingWrapper)
    {
        $this->shippingWrapper = $shippingWrapper;
    }

    /**
     * Performs all processes to be performed after the order creation.
     *
     * Flushes all loaded order and related entities.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     *
     * @return $this Self object
     */
    public function loadOrderShippingMethod(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $shippingMethodId = $cart->getShippingMethod();

        if (empty($shippingMethodId)) {
            return $this;
        }

        $shippingMethod = $this
            ->shippingWrapper
            ->getOneById($cart, $shippingMethodId);

        if ($shippingMethod instanceof ShippingMethod) {
            $order->setShippingAmount($shippingMethod->getPrice());
            $order->setShippingMethod($shippingMethod);
        }
    }
}
