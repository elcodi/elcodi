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

namespace Elcodi\Component\Cart\Services;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Services\CurrencyConverter;

/**
 * Class CartPricesLoader.
 *
 * Api Methods:
 *
 * * loadCartProductsAmount(CartInterface)
 * * loadCartTotalAmount(CartInterface)
 *
 * @api
 */
class CartPricesLoader
{
    /**
     * @var WrapperInterface
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * @var CurrencyConverter
     *
     * Currency Converter
     */
    private $currencyConverter;

    /**
     * Built method.
     *
     * @param WrapperInterface  $currencyWrapper   Currency Wrapper
     * @param CurrencyConverter $currencyConverter Currency Converter
     */
    public function __construct(
        WrapperInterface $currencyWrapper,
        CurrencyConverter $currencyConverter
    ) {
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Load cart products prices.
     *
     * @param CartInterface $cart Cart
     */
    public function loadCartProductsAmount(CartInterface $cart)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $productAmount = Money::create(0, $currency);

        /**
         * Calculate Amount and ProductAmount.
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $cartLine = $this->loadCartLinePrices($cartLine);

            /**
             * @var MoneyInterface $productAmount
             * @var MoneyInterface $totalAmount
             */
            $convertedProductAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $cartLine->getProductAmount(),
                    $currency
                );

            $productAmount = $productAmount
                ->add($convertedProductAmount->multiply(
                    $cartLine->getQuantity()
                ));
        }

        $cart->setProductAmount($productAmount);
    }

    /**
     * Load cart total price.
     *
     * @param CartInterface $cart Cart
     */
    public function loadCartTotalAmount(CartInterface $cart)
    {
        $currency = $this
            ->currencyWrapper
            ->get();

        $finalAmount = clone $cart->getProductAmount();

        /**
         * Calculates the shipping amount.
         */
        $shippingAmount = $cart->getShippingAmount();
        if ($shippingAmount instanceof MoneyInterface) {
            $convertedShippingAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $shippingAmount,
                    $currency
                );
            $finalAmount = $finalAmount->add($convertedShippingAmount);
        }

        /**
         * Calculates the coupon amount.
         */
        $couponAmount = $cart->getCouponAmount();
        if ($couponAmount instanceof MoneyInterface) {
            $convertedCouponAmount = $this
                ->currencyConverter
                ->convertMoney(
                    $couponAmount,
                    $currency
                );
            $finalAmount = $finalAmount->subtract($convertedCouponAmount);
        }

        $cart->setAmount($finalAmount);
    }

    /**
     * Loads CartLine prices.
     * This method does not consider Coupon.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface Line with prices loaded
     */
    private function loadCartLinePrices(CartLineInterface $cartLine)
    {
        $purchasable = $cartLine->getPurchasable();
        $productPrice = $purchasable->getPrice();

        /**
         * If present, reducedPrice will be used as product price in current CartLine.
         */
        if ($purchasable->getReducedPrice()->getAmount() > 0) {
            $productPrice = $purchasable->getReducedPrice();
        }

        /**
         * Setting amounts for current CartLine.
         *
         * Line Currency was set by CartManager::addProduct when factorizing CartLine
         */
        $cartLine->setProductAmount($productPrice);
        $cartLine->setAmount($productPrice->multiply($cartLine->getQuantity()));

        return $cartLine;
    }
}
