<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Cart\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\Shipping\Wrapper\ShippingWrapper;

/**
 * Class CartShippingMethodEventListener
 */
class CartShippingMethodEventListener
{
    /**
     * @var ShippingWrapper
     *
     * Shipping wrapper
     */
    private $shippingWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency Converter
     */
    private $currencyConverter;

    /**
     * Construct
     *
     * @param ShippingWrapper   $shippingWrapper   Shipping wrapper
     * @param CurrencyConverter $currencyConverter Currency Converter
     */
    public function __construct(
        ShippingWrapper $shippingWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->shippingWrapper = $shippingWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Performs all processes to be performed after the order creation
     *
     * Flushes all loaded order and related entities.
     *
     * @param CartOnLoadEvent $event Event
     *
     * @return $this Self object
     */
    public function loadShippingPrice(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $shippingMethodId = $cart->getShippingMethod();

        if (empty($shippingMethodId)) {
            return $this;
        }

        $shippingMethod = $this
            ->shippingWrapper
            ->getOneById($cart, $shippingMethodId);

        if ($shippingMethod instanceof ShippingMethod) {
            $cartAmount = $cart->getAmount();
            $convertedShippingAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $shippingMethod->getPrice(),
                    $cartAmount->getCurrency()
                );

            $cart
                ->setAmount(
                    $cartAmount->add($convertedShippingAmount)
                );
        }

        return $this;
    }
}
