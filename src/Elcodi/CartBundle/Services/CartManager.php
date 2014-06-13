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

namespace Elcodi\CartBundle\Services;

use Elcodi\CartBundle\EventDispatcher\CartLineEventDispatcher;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\EventDispatcher\CartEventDispatcher;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Factory\CartLineFactory;
use Elcodi\CartBundle\Factory\CartFactory;

/**
 * Cart manager service
 *
 * This service hosts all cart and cartLine related actions.
 * This class has not states, so every method just has input parameters and
 * return some output values.
 *
 * Some of these methods also can dispatch some Cart events
 *
 * Api Methods:
 *
 * * addLine(AbstractCart, CartLine) : self
 * * removeLine(AbstractCart, CartLine) : self
 * * silentRemoveLine(AbstractCart, CartLine) : self
 * * emptyLines() : self
 *
 * * increaseCartLineQuantity(CartLine, $quantity) : self
 * * decreaseCartLineQuantity(CartLine, $quantity) : self
 * * setCartLineQuantity(CartLine, $quantity) : self
 *
 * * addProduct(AbstractCart, ProductInterface, $quantity) : self
 */
class CartManager
{
    /**
     * @var CartEventDispatcher
     *
     * Cart Event Dispatcher
     */
    protected $cartEventDispatcher;

    /**
     * @var CartLineEventDispatcher
     *
     * CartLine Event Dispatcher
     */
    protected $cartLineEventDispatcher;

    /**
     * @var CartFactory
     *
     * cartFactory
     */
    protected $cartFactory;

    /**
     * @var CartLineFactory
     *
     * CartLine Factory
     */
    protected $cartLineFactory;

    /**
     * Construct method
     *
     * @param CartEventDispatcher     $cartEventDispatcher     Cart Event Dispatcher
     * @param CartLineEventDispatcher $cartLineEventDispatcher CartLine Event dispatcher
     * @param CartFactory             $cartFactory             Cart factory
     * @param CartLineFactory         $cartLineFactory         CartLine factory
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        CartLineEventDispatcher $cartLineEventDispatcher,
        CartFactory $cartFactory,
        CartLineFactory $cartLineFactory
    )
    {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartLineEventDispatcher = $cartLineEventDispatcher;
        $this->cartFactory = $cartFactory;
        $this->cartLineFactory = $cartLineFactory;
    }

    /**
     * Adds cartLine to Cart
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function addLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $cartLine->setCart($cart);
        $cart->addCartLine($cartLine);

        $this
            ->cartLineEventDispatcher
            ->dispatchCartLineOnAddEvent(
                $cart,
                $cartLine
            );

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Removes CartLine from Cart
     *
     * This method dispatches all Cart Load events, if defined.
     * If this method is called in CartCheckEvents, $dispatchEvents should be
     * set to false
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function removeLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $this->silentRemoveLine($cart, $cartLine);

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Removes CartLine from Cart
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function silentRemoveLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    )
    {
        $cart->removeCartLine($cartLine);

        $this
            ->cartLineEventDispatcher
            ->dispatchCartLineOnRemoveEvent(
                $cart,
                $cartLine
            );

        return $this;
    }

    /**
     * Empty cart.
     *
     * This method dispatches all Cart Load events
     *
     * @param CartInterface $cart Cart
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function emptyLines(
        CartInterface $cart
    )
    {
        $cart
            ->getCartLines()
            ->map(function (CartLineInterface $cartLine) use ($cart) {

                $this->silentRemoveLine($cart, $cartLine);
            });

        $this
            ->cartEventDispatcher
            ->dispatchCartOnEmptyEvent($cart);

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Edit CartLine
     *
     * Only manages this CartLine if already exists in CartLine
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param ProductInterface  $product  Product
     * @param integer           $quantity quantity of products
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function editCartLine(
        CartLineInterface $cartLine,
        ProductInterface $product,
        $quantity
    )
    {
        $cart = $cartLine->getCart();

        if (!($cart instanceof CartInterface)) {
            return $this;
        }

        $cartLine->setProduct($product);
        $this->setCartLineQuantity($cartLine, $quantity);

        return $this;
    }

    /**
     * Adds quantity to cartLine
     *
     * If quantity is higher than item stock, throw exception
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param integer           $quantity Number of units to decrease CartLine quantity
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function increaseCartLineQuantity(
        CartLineInterface $cartLine,
        $quantity
    )
    {
        if (!is_int($quantity) || empty($quantity)) {
            return $this;
        }

        $newQuantity = $cartLine->getQuantity() + $quantity;

        return $this->setCartLineQuantity(
            $cartLine,
            $newQuantity
        );
    }

    /**
     * Removes quantity to cartLine
     *
     * If quantity is 0, deletes whole line
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param integer           $quantity Number of units to decrease CartLine quantity
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function decreaseCartLineQuantity(
        CartLineInterface $cartLine,
        $quantity
    )
    {
        if (!is_int($quantity) || empty($quantity)) {
            return $this;
        }

        return $this->increaseCartLineQuantity(
            $cartLine,
            ($quantity * -1)
        );
    }

    /**
     * Sets quantity to cartLine
     *
     * If quantity is higher than item stock, throw exception
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param integer           $quantity CartLine quantity to set
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function setCartLineQuantity(
        CartLineInterface $cartLine,
        $quantity
    )
    {
        $cart = $cartLine->getCart();

        if (!($cart instanceof CartInterface)) {
            return $this;
        }

        /**
         * If $quantity is an integer and is less or equal than 0, means that
         * full line must be removed.
         *
         * Otherwise, $quantity can have two values:
         * * null or false - Quantity is not affected
         * * integer higher than 0, quantity is edited and all changes are
         *   recalculated.
         */
        if (is_int($quantity) && $quantity <= 0) {

            $this->silentRemoveLine($cart, $cartLine);

        } elseif (is_int($quantity)) {

            $cartLine->setQuantity($quantity);

            $this
                ->cartLineEventDispatcher
                ->dispatchCartLineOnEditEvent(
                    $cart,
                    $cartLine
                );

        } else {

            /**
             * Nothing to do here. Quantity value is not an integer, so will not
             * be treated as such
             */

            return $this;
        }

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Add a product to Cart as a new CartLine
     *
     * This method creates a new CartLine with $quantity Product.
     * If the product is already in the Cart, it just increments
     * the quantity
     *
     * @param CartInterface    $cart     Cart
     * @param ProductInterface $product  Product to add
     * @param integer          $quantity Number of units to decrease CartLine
     *
     * @return CartManager self Object
     *
     * @api
     */
    public function addProduct(
        CartInterface $cart,
        ProductInterface $product,
        $quantity
    )
    {
        /**
         * If quantity is not a number or is 0 or less, product is not added
         * into cart
         */
        if (!is_int($quantity) || $quantity <= 0) {
            return $this;
        }

        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            if ($cartLine->getProduct()->getId() == $product->getId()) {

                /**
                 * Product already in the Cart, increase quantity
                 */

                return $this->increaseCartLineQuantity($cartLine, $quantity);
            }
        }

        $cartLine = $this->cartLineFactory->create();
        $cartLine
            ->setProduct($product)
            ->setQuantity($quantity);

        $this->addLine($cart, $cartLine);

        return $this;
    }
}
