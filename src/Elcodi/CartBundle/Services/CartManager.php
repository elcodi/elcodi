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

use Elcodi\CartBundle\Wrapper\CartWrapper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CartBundle\ElcodiCartEvents;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Factory\CartLineFactory;
use Elcodi\CartBundle\Event\CartOnCheckEvent;
use Elcodi\CartBundle\Event\CartOnLoadEvent;
use Elcodi\CartBundle\Event\CartPostCheckEvent;
use Elcodi\CartBundle\Event\CartPostLoadEvent;
use Elcodi\CartBundle\Event\CartPreCheckEvent;
use Elcodi\CartBundle\Event\CartPreLoadEvent;
use Elcodi\CartBundle\Factory\CartFactory;
use Elcodi\CartBundle\Exception\CartLineOutOfStockException;

/**
 * Cart manager service
 *
 * This service hosts all cart and cartLine related actions.
 * This class has not states, so every method just has input parameters and
 * return some output values.
 *
 * Some of these methods also can dispatch some Cart events
 *
 * Public Methods:
 *
 * * addLine(AbstractCart, CartLine)
 * * removeLine(AbstractCart, CartLine)
 * * emptyLines()
 *
 * * increaseCartLineQuantity(CartLine, $quantity)
 * * decreaseCartLineQuantity(CartLine, $quantity)
 * * setCartLineQuantity(CartLine, $quantity)
 *
 * * addProduct(AbstractCart, Item, $quantity, $customizations)
 */
class CartManager
{
    /**
     * @var ObjectManager
     *
     * Cartline Manager
     */
    protected $cartLineManager;

    /**
     * @var EventDispatcherInterface
     *
     * Event Dispatcher
     */
    protected $eventDispatcher;

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
     * @var CartWrapper
     *
     * CartWrapper
     */
    protected $cartWrapper;

    /**
     * Construct method
     *
     */
    public function __construct(
        ObjectManager $cartLineManager,
        EventDispatcherInterface $eventDispatcher,
        CartFactory $cartFactory,
        CartLineFactory $cartLineFactory,
        CartWrapper $cartWrapper
    )
    {
        $this->cartFactory = $cartFactory;
        $this->cartLineManager = $cartLineManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->cartLineFactory = $cartLineFactory;
        $this->cartWrapper = $cartWrapper;
    }

    /**
     * Loads a Cart and fires related events
     *
     * If the Cart is pristine, i.e. has no id set,
     * a new one will be created and pertisted. The
     * newly created Cart will not be flushed
     *
     * @param CartInterface $cart
     *
     * @return CartInterface loaded Cart
     */
    public function loadCart(CartInterface $cart)
    {
        if ($cart->getId()) {

            $this->dispatchCartCheckEvents($cart);
            $this->dispatchCartLoadEvents($cart);

        }

        return $cart;
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
     */
    public function addLine(CartInterface $cart, CartLineInterface $cartLine)
    {
        $cartLine->setCart($cart);
        $cart->addCartLine($cartLine);

        /**
         * When we persist cartLine, we are also persisting Cart if no persisted
         * because are related with cascade ALL
         */
        $this->cartLineManager->persist($cartLine);

        $this->dispatchCartCheckEvents($cart);
        $this->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Removes CartLine from Cart
     *
     * This method dispatches all Cart Load events, if defined.
     * If this method is called in CartCheckEvents, $dispatchEvents should be
     * set to false
     *
     * @param CartInterface     $cart           Cart
     * @param CartLineInterface $cartLine       Cart line
     * @param boolean           $dispatchEvents This method must dispatch events
     *
     * @return CartManager self Object
     */
    public function removeLine(
        CartInterface $cart,
        CartLineInterface $cartLine,
        $dispatchEvents = true
    )
    {
        $lines = $cart->getCartLines();
        $lines->removeElement($cartLine);
        $this->cartLineManager->remove($cartLine);

        if ($dispatchEvents) {
            $this->dispatchCartLoadEvents($cart);
        }

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
     */
    public function emptyLines(CartInterface $cart)
    {
        $cartLines = $cart->getCartLines();

        foreach ($cartLines as $cartLine) {
            $this->cartLineManager->remove($cartLine);
        }

        $cart->setCartLines(new ArrayCollection);
        $this->dispatchCartLoadEvents($cart);

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
     */
    public function editCartLine(CartLineInterface $cartLine, ProductInterface $product, $quantity = null)
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
     * @throws CartLineOutOfStockException
     */
    public function increaseCartLineQuantity(CartLineInterface $cartLine, $quantity = 1)
    {
        $newQuantity = $cartLine->getQuantity() + $quantity;

        return $this->setCartLineQuantity($cartLine, $newQuantity);
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
     */
    public function decreaseCartLineQuantity(CartLineInterface $cartLine, $quantity = 1)
    {
        $newQuantity = $cartLine->getQuantity() - $quantity;

        return $this->setCartLineQuantity($cartLine, $newQuantity);
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
     * @throws CartLineOutOfStockException
     */
    public function setCartLineQuantity(CartLineInterface $cartLine, $quantity = null)
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

            $this->removeLine($cart, $cartLine, false);

        } elseif (is_int($quantity)) {

            $cartLine->setQuantity($quantity);
        }

        $this->dispatchCartCheckEvents($cart);
        $this->dispatchCartLoadEvents($cart);

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
     * @throws CartLineOutOfStockException
     */
    public function addProduct(CartInterface $cart, ProductInterface $product, $quantity = 1)
    {
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            if ($cartLine->getProduct()->getId() == $product->getId()) {
                // Product already in the Cart, increase quantity
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

    /**
     * Throw cart events for check process.
     * This events can affect cart with some removals of invalid elements
     *
     * @param CartInterface $cart Cart
     *
     * @return CartManager self object
     */
    public function dispatchCartCheckEvents(CartInterface $cart)
    {
        /**
         * Dispatching precheck event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_PRECHECK,
            new CartPreCheckEvent($cart)
        );

        /**
         * Dispatching oncheck event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_ONCHECK,
            new CartOnCheckEvent($cart)
        );

        /**
         * Dispatching postcheck event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_POSTCHECK,
            new CartPostCheckEvent($cart)
        );

        return $this;
    }

    /**
     * Throw cart events for load process
     * This events can affect cart with price changes
     *
     * @param CartInterface $cart Cart
     *
     * @return CartManager self object
     */
    public function dispatchCartLoadEvents(CartInterface $cart)
    {
        /**
         * Dispatching preload event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_PRELOAD,
            new CartPreLoadEvent($cart)
        );

        /**
         * Dispatching onload event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_ONLOAD,
            new CartOnLoadEvent($cart)
        );

        /**
         * Dispatching postload event
         */
        $this->eventDispatcher->dispatch(
            ElcodiCartEvents::CART_POSTLOAD,
            new CartPostLoadEvent($cart)
        );

        return $this;
    }
}
