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

namespace Elcodi\Component\Shipping\EventListener;

use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;
use Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface;

/**
 * Class RefreshShippingAmountEventListener
 *
 * This event listener should update the cart given in the event, applying
 * all the shipping features.
 */
class RefreshShippingAmountEventListener
{
    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    protected $currencyConverter;

    /**
     * Construct method
     *
     * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
     * @param CurrencyConverter $currencyConverter Currency converter
     */
    public function __construct(
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Method subscribed to CartLoad event
     *
     * Checks if there is a ShippingRange in given Cart. If it is, updates the
     * price of the field
     *
     * @param CartOnLoadEvent $event Event
     */
    public function refreshShippingAmount(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $cartShippingRange = $cart->getShippingRange();
        $currency = $this
            ->currencyWrapper
            ->loadCurrency();

        if ($cartShippingRange instanceof ShippingRangeInterface) {
            $shippingAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $cartShippingRange->getPrice(),
                    $currency
                );

            $cart->setAmount(
                $cart
                    ->getAmount()
                    ->add($shippingAmount)
            );
        } else {
            $shippingAmount = Money::create(
                0,
                $currency
            );
        }

        $cart->setShippingAmount($shippingAmount);
    }
}
