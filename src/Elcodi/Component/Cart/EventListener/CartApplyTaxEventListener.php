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

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Event\CartPreLoadEvent;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Cart\Services\CartManager;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;
use Elcodi\Component\Product\ElcodiProductStock;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class CartLoadEventListener
 *
 * These event listeners are supposed to be used when a cart is loaded
 *
 * Public methods:
 *
 * * checkCartIntegrity
 * * loadCart
 * * saveCart
 * * loadCartQuantities
 */
class CartApplyTaxEventListener
{
    /**
     * @var WrapperInterface
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency Converter
     */
    protected $currencyConverter;

    /**
     * Built method
     *
     * @param WrapperInterface    $currencyWrapper     Currency Wrapper
     * @param CurrencyConverter   $currencyConverter   Currency Converter
     */
    public function __construct(
        WrapperInterface $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    public function loadCartTaxes(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        /**
         * Recalculate cart amount. Prices might have
         * changed so we need to flush $cart
         */
        $this->calculateCartTaxes($cart);
    }

    /**
     * Calculates Tax amounts for a given a Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    protected function calculateCartTaxes(CartInterface $cart)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $taxAmount = Money::create(0, $currency);

        $productAmount = Money::create(0, $currency);
        $preTaxProductAmount = Money::create(0, $currency);
        $taxProductAmount = Money::create(0, $currency);

        /**
         * Calculate Amount and ProductAmount
         *
         * We assume that Cart Lines have been
         * already calculated
         */
        foreach ($cart->getCartLines() as $cartLine) {
            /**
             * @var CartLineInterface $cartLine
             */

            $productAmount = $productAmount->add(
                $this
                    ->currencyConverter
                    ->convertMoney(
                        $cartLine->getProductAmount(),
                        $currency
                    )
            );

            $preTaxProductAmount = $preTaxProductAmount->add(
                $this
                    ->currencyConverter
                    ->convertMoney(
                        $cartLine->getPreTaxProductAmount(),
                        $currency
                    )
            );

            $taxProductAmount = $taxProductAmount->add(
                $this
                    ->currencyConverter
                    ->convertMoney(
                        $cartLine->getTaxProductAmount(),
                        $currency
                    )
            );

        }

        $cart
            ->setProductAmount($productAmount)
            ->setTaxProductAmount($taxProductAmount)
            ->setPreTaxProductAmount($preTaxProductAmount)
            ->setAmount($productAmount)
            ->setTaxAmount($taxProductAmount)
            ->setPreTaxAmount($preTaxProductAmount);
    }
}
