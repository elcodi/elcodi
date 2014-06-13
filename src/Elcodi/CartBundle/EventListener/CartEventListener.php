<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Services\CurrencyConverter;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\EventDispatcher\CartEventDispatcher;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\Services\CartManager;
use Elcodi\CartBundle\Event\OrderOnCreatedEvent;

/**
 * Class CartEventListener
 *
 * Subscribers:
 *
 * * onCartPreLoad
 *
 * * onCartLoadPrices
 * * onCartLoadFlush
 * * onCartLoadQuantities
 *
 * * postOrderCreated
 */
class CartEventListener
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    protected $cartObjectManager;

    /**
     * @var CartEventDispatcher
     *
     * Cart EventDispatcher
     */
    protected $cartEventDispatcher;

    /**
     * @var CartManager
     *
     * Cart Manager
     */
    protected $cartManager;

    /**
     * @var CurrencyWrapper
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
     * @param ObjectManager       $cartObjectManager   ObjectManager for Cart entity
     * @param CartEventDispatcher $cartEventDispatcher Cart event dispatcher
     * @param CartManager         $cartManager         Cart Manager
     * @param CurrencyWrapper     $currencyWrapper     Currency Wrapper
     * @param CurrencyConverter   $currencyConverter   Currency Converter
     */
    public function __construct(
        ObjectManager $cartObjectManager,
        CartEventDispatcher $cartEventDispatcher,
        CartManager $cartManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter
    )
    {
        $this->cartObjectManager = $cartObjectManager;
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Check cart integrity
     *
     * @param CartPreLoadEvent $event Event
     *
     * @api
     */
    public function onCartPreLoad(CartPreLoadEvent $event)
    {
        /**
         * @var CartInterface $cart
         */
        $cart = $event->getCart();

        /**
         * Check every CartLine
         *
         * @var CartLineInterface $cartLine
         */
        foreach ($cart->getCartLines() as $cartLine) {

            $this->checkCartLine($cartLine);
        }
    }

    /**
     * Load cart prices. As these prices are calculated on time, because they
     * are not flushed into database
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
     *
     * @api
     */
    public function onCartLoadPrices(CartOnLoadEvent $event)
    {
        /**
         * Recalculate cart amount. Prices might have
         * changed so we need to flush $cart
         */
        $this->loadCartPrices(
            $event->getCart()
        );
    }

    /**
     * Flushes all loaded cart and related entities.
     *
     * @param CartOnLoadEvent $event Event
     *
     * @api
     */
    public function onCartLoadFlush(CartOnLoadEvent $event)
    {
        $this->cartObjectManager->persist(
            $event->getCart()
        );
        $this->cartObjectManager->flush();
    }

    /**
     * Load cart quantities.
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
     *
     * @api
     */
    public function onCartLoadQuantities(CartOnLoadEvent $event)
    {
        $this->loadCartQuantities(
            $event->getCart()
        );
    }

    /**
     * After an Order is created, the cart is set as Ordered enabling related
     * flag
     *
     * @param OrderOnCreatedEvent $event Event
     *
     * @api
     */
    public function onOrderCreated(OrderOnCreatedEvent $event)
    {
        $cart = $event
            ->getCart()
            ->setOrdered(true);

        $this->cartObjectManager->flush($cart);
    }

    /**
     * Check CartLine integrity
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface CartLine
     */
    protected function checkCartLine(CartLineInterface $cartLine)
    {
        $cart = $cartLine->getCart();
        $product = $cartLine->getProduct();

        if (
            !($product instanceof ProductInterface) ||
            !($product->isEnabled()) ||
            $cartLine->getQuantity() <= 0
        ) {
            $this->cartManager->silentRemoveLine(
                $cart,
                $cartLine
            );

            /**
             * An inconsistent cart event is dispatched
             */
            $this
                ->cartEventDispatcher
                ->dispatchCartInconsistentEvent(
                    $cart,
                    $cartLine
                );
        }

        if ($cartLine->getQuantity() > $product->getStock()) {

            $cartLine->setQuantity($product->getStock());
        }

        return $cartLine;
    }

    /**
     * Calculates all the amounts for a given a Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    protected function loadCartPrices(CartInterface $cart)
    {
        $currency = $this->currencyWrapper->loadCurrency();
        $productAmount = Money::create(0, $currency);

        /**
         * Calculate Amount and ProductAmount
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
            $productAmount = $productAmount->add($convertedProductAmount);
        }

        $cart
            ->setProductAmount($productAmount)
            ->setAmount($productAmount);
    }

    /**
     * Loads CartLine prices.
     * This method does not consider Coupon
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface Line with prices loaded
     */
    protected function loadCartLinePrices(CartLineInterface $cartLine)
    {
        $product = $cartLine->getProduct();
        $productPrice = $product->getPrice();

        /**
         * If reducedPrice is defined, found value will be used as real product
         * price.
         */
        if ($product->getReducedPrice() instanceof Money) {

            $productPrice = $product->getReducedPrice();
        }

        /**
         * Setting amounts for this CartLine.
         * Line Currency has already be set when factorying CartLine
         * by CartManager::addProduct
         */
        $cartLine->setProductAmount($productPrice->multiply($cartLine->getQuantity()));
        $cartLine->setAmount($cartLine->getProductAmount());

        return $cartLine;
    }

    /**
     * This method calculates all quantities given a Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    protected function loadCartQuantities(CartInterface $cart)
    {
        $quantity = 0;

        /**
         * Calculate max shipping delay
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $quantity += $cartLine->getQuantity();
        }

        $cart->setQuantity($quantity);

        return $cart;
    }
}
