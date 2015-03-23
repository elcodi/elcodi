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

namespace Elcodi\Component\Cart\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Event\CartOnLoadEvent;
use Elcodi\Component\Cart\Event\CartPreLoadEvent;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Cart\Services\CartManager;
use Elcodi\Component\Configuration\Services\ConfigurationManager;
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
class CartLoadEventListener
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
     * @var ConfigurationManager
     *
     * A configuration manager
     */
    protected $configurationManager;

    /**
     * Built method
     *
     * @param ObjectManager        $cartObjectManager    ObjectManager for Cart
     *                                                   entity
     * @param CartEventDispatcher  $cartEventDispatcher  Cart event dispatcher
     * @param CartManager          $cartManager          Cart Manager
     * @param CurrencyWrapper      $currencyWrapper      Currency Wrapper
     * @param CurrencyConverter    $currencyConverter    Currency Converter
     * @param ConfigurationManager $configurationManager A configuration manager
     */
    public function __construct(
        ObjectManager $cartObjectManager,
        CartEventDispatcher $cartEventDispatcher,
        CartManager $cartManager,
        CurrencyWrapper $currencyWrapper,
        CurrencyConverter $currencyConverter,
        ConfigurationManager $configurationManager
    ) {
        $this->cartObjectManager = $cartObjectManager;
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
        $this->currencyWrapper = $currencyWrapper;
        $this->currencyConverter = $currencyConverter;
        $this->configurationManager = $configurationManager;
    }

    /**
     * Check cart integrity
     *
     * @param CartPreLoadEvent $event Event
     */
    public function checkCartIntegrity(CartPreLoadEvent $event)
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
    public function loadCartPrices(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        /**
         * Recalculate cart amount. Prices might have
         * changed so we need to flush $cart
         */
        $this->calculateCartPrices($cart);
    }

    /**
     * Load cart quantities.
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
     */
    public function loadCartQuantities(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $this->calculateCartQuantities($cart);
    }

    /**
     * Flushes all loaded cart and related entities.
     *
     * We only persist it if have lines loaded inside, so empty carts will never
     * be persisted
     *
     * @param CartOnLoadEvent $event Event
     */
    public function saveCart(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        if (!$cart->getCartLines()->isEmpty()) {
            $this->cartObjectManager->persist($cart);
        }

        $this
            ->cartObjectManager
            ->flush();
    }

    /**
     * Protected methods
     */

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
        $cart        = $cartLine->getCart();
        $purchasable = $cartLine->getPurchasable();
        $useStock    = $this
            ->configurationManager
            ->get('product.use_stock');

        if (
            !($purchasable instanceof PurchasableInterface) ||
            !($purchasable->isEnabled()) ||
            (
                $useStock &&
                $cartLine->getQuantity() <= 0
            )
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
         *
         * This checking has sense when the Product has not infinite stock
         */
        if (
            ($cartLine->getProduct()->getStock() !== ElcodiProductStock::INFINITE_STOCK) &&
            ($cartLine->getQuantity() > $purchasable->getStock())
        ) {
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
    protected function calculateCartPrices(CartInterface $cart)
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

            $productAmount = $productAmount
                ->add($convertedProductAmount->multiply(
                    $cartLine->getQuantity()
                ));
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
         * Line Currency was set by CartManager::addProduct when factorizing CartLine
         */
        $cartLine->setProductAmount($productPrice);
        $cartLine->setAmount($productPrice->multiply($cartLine->getQuantity()));

        return $cartLine;
    }

    /**
     * This method calculates all quantities given a Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    protected function calculateCartQuantities(CartInterface $cart)
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
