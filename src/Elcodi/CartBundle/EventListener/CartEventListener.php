<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Exception;

use Elcodi\CartBundle\Exception\CartLineProductUnavailableException;
use Elcodi\CartBundle\Exception\CartLineOutOfStockException;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Event\CartOnCheckEvent;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\Services\CartManager;

/**
 * Class CartEventListener
 */
class CartEventListener
{
    /**
     * @var CartManager
     *
     * cartManager
     */
    protected $cartManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Built method
     *
     * @param CartManager   $cartManager   Cart Manager
     * @param ObjectManager $objectManager Object Manager
     */
    public function __construct(CartManager $cartManager, ObjectManager $objectManager)
    {
        $this->cartManager = $cartManager;
        $this->objectManager = $objectManager;
    }

    /**
     * Check cart integrity
     *
     * @param CartOnCheckEvent $event Event
     *
     * @throws CartLineOutOfStockException
     * @throws CartLineProductUnavailableException
     */
    public function onCartCheck(CartOnCheckEvent $event)
    {
        /**
         * @var CartInterface $cart
         */
        $cart = $event->getCart();
        $cartQuantity = 0;

        /**
         * Check every CartLine
         *
         * @var CartLineInterface $cartLine
         */
        foreach ($cart->getCartLines() as $cartLine) {

            try {
                $this->checkCartLine($cartLine);

            } catch (Exception $e) {

                $this->cartManager->removeLine($cart, $cartLine, false);
            }

            $cartQuantity += $cartLine->getQuantity();
        }

        $cart->setQuantity($cartQuantity);
    }

    /**
     * Load cart
     *
     * @param CartOnLoadEvent $event Event
     */
    public function onCartLoad(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        // Recalculate cart amount. Prices might have
        // changed so we need to flush $cart
        $this->loadPrices($cart);

        $this->objectManager->flush($cart);
    }

    /**
     * Check CartLine integrity
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @throws CartLineOutOfStockException
     * @throws CartLineProductUnavailableException
     */
    protected function checkCartLine(CartLineInterface $cartLine)
    {
        $product = $cartLine->getProduct();

        if (!$product->isEnabled()) {

            throw new CartLineProductUnavailableException('Current product is not available');
        }

        if ($cartLine->getQuantity() > $product->getStock()) {

            throw new CartLineOutOfStockException('Current product is out of stock');
        }
    }

    /**
     * This method calculates all prices given a Cart
     *
     * @param CartInterface $cart Cart
     */
    protected function loadPrices(CartInterface $cart)
    {
        $productAmount = 0;
        $price = 0;

        /**
         * Calculate max shipping delay
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $cartLine = $this->loadCartLinePrices($cartLine);
            $productAmount += $cartLine->getProductAmount();
            $price += $cartLine->getAmount();
        }

        $cart
            ->setProductAmount($productAmount)
            ->setAmount($price);
    }

    /**
     * Loads CartLine prices.
     *
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
        if ($product->getReducedPrice() > 0.00) {
            $productPrice = $product->getReducedPrice();
        }

        $cartLine->setProductAmount($productPrice * $cartLine->getQuantity());
        $cartLine->setAmount($cartLine->getProductAmount());

        return $cartLine;
    }
}
