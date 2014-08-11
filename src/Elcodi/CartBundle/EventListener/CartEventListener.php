<?php

/**
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

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartBundle\Event\OrderOnCreatedEvent;
use Elcodi\CartBundle\EventDispatcher\CartEventDispatcher;
use Elcodi\CartBundle\Services\CartManager;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\CurrencyBundle\Services\CurrencyConverter;
use Elcodi\CurrencyBundle\Wrapper\CurrencyWrapper;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;

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
     * We only persist it if have lines loaded inside, so empty carts will never
     * be persisted
     *
     * @param CartOnLoadEvent $event Event
     */
    public function onCartLoadFlush(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        if (!$cart->getCartLines()->isEmpty()) {

            $this->cartObjectManager->persist(
                $event->getCart()
            );
        }

        $this->cartObjectManager->flush();
    }

    /**
     * Load cart quantities.
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
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
     * When a purchasable is not enabled or its quantity is <=0,
     * the line is discarded and a ElcodiCartEvents::CART_INCONSISTENT
     * event is fired.
     *
     * A further check on stock availability is performed so that when
     * $quantity is greater that the available units, $quantity for this
     * CartLine is set to Purchasable::$stock number
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface CartLine
     */
    protected function checkCartLine(CartLineInterface $cartLine)
    {
        $cart = $cartLine->getCart();
        $purchasable = $cartLine->getPurchasable();

        if (
            !($purchasable instanceof PurchasableInterface) ||
            !($purchasable->isEnabled()) ||
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

        /**
         * We cannot exceed available stock for a given purchasable
         * when setting CartLine::$quantity
         */
        if ($cartLine->getQuantity() > $purchasable->getStock()) {

            $cartLine->setQuantity($purchasable->getStock());
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
         * Line Currency was set by CartManager::addProduct when factorying CartLine
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
