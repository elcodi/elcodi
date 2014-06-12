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

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\EventDispatcher\CartEventDispatcher;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\Services\CartManager;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CartBundle\Event\OrderOnCreatedEvent;

/**
 * Class CartEventListener
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
     * CartEventDispatcher
     */
    protected $cartEventDispatcher;

    /**
     * @var CartManager
     *
     * cartManager
     */
    protected $cartManager;

    /**
     * Built method
     *
     * @param ObjectManager       $cartObjectManager   ObjectManager for Cart entity
     * @param CartEventDispatcher $cartEventDispatcher Cart event dispatcher
     * @param CartManager         $cartManager         Cart Manager
     */
    public function __construct(
        ObjectManager $cartObjectManager,
        CartEventDispatcher $cartEventDispatcher,
        CartManager $cartManager
    )
    {
        $this->cartObjectManager = $cartObjectManager;
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
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
     * Load cart
     *
     * @param CartOnLoadEvent $event Event
     *
     * @api
     */
    public function onCartLoad(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        /**
         * Recalculate cart amount. Prices might have
         * changed so we need to flush $cart
         */
        $this->loadCartPrices($cart);
    }

    /**
     * Performs all processes to be performed after the cart load
     *
     * Flushes all loaded cart and related entities.
     *
     * @param CartOnLoadEvent $event Event
     *
     * @api
     */
    public function onCartLoadFlush(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        $this->loadCartQuantities($cart);

        $this->cartObjectManager->persist($cart);
        $this->cartObjectManager->flush();
    }

    /**
     * After an Order is created, the cart is set as Ordered enabling related
     * flag
     *
     * @param OrderOnCreatedEvent $event Event
     *
     * @api
     */
    public function postOrderCreated(OrderOnCreatedEvent $event)
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
     * This method calculates all prices given a Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    protected function loadCartPrices(CartInterface $cart)
    {
        $productAmount = new Money(0, $cart->getCurrency());
        $totalAmount = new Money(0, $cart->getCurrency());

        /**
         * Calculate max shipping delay
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $cartLine = $this->loadCartLinePrices($cartLine);
            $productAmount = $productAmount->add($cartLine->getProductAmount());
            $totalAmount = $totalAmount->add($cartLine->getAmount());
        }

        $cart
            ->setProductAmount($productAmount)
            ->setAmount($totalAmount);
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
        if ($product->getReducedPrice()->getAmount() > 0) {

            $productPrice = $product->getReducedPrice();
        }

        /*
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
