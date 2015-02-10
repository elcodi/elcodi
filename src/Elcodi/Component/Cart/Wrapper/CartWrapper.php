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

namespace Elcodi\Component\Cart\Wrapper;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Cart\Factory\CartFactory;
use Elcodi\Component\Cart\Repository\CartRepository;
use Elcodi\Component\Cart\Services\CartSessionManager;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Wrapper\CustomerWrapper;

/**
 * Class CartWrapper
 *
 * Envelopes a Cart object and provides the minimum logic to
 * load it from HTTP Session, from the Customer collection
 * of pending Carts or by factoring a pristine Cart.
 *
 * The most useful method in this wrapper is loadCart(), which
 * will behave according to different scenarios:
 *
 * - When the Customer has pending Carts, the last Cart form
 *   this collection is returned
 * - When there is a Cart in session, it is associated with
 *   the Customer and is returned
 * - When there is no Cart in session, a new one is factored
 *
 */
class CartWrapper
{
    /**
     * @var CartEventDispatcher
     *
     * Cart EventDispatcher
     */
    protected $cartEventDispatcher;

    /**
     * @var CartSessionManager
     *
     * CartSessionManager
     */
    protected $cartSessionManager;

    /**
     * @var CartRepository
     *
     * CartRepository
     */
    protected $cartRepository;

    /**
     * @var CartFactory
     *
     * CartFactory
     */
    protected $cartFactory;

    /**
     * @var CustomerWrapper
     *
     * CustomerWrapper
     */
    protected $customerWrapper;

    /**
     * @var CartInterface
     *
     * Cart loaded
     */
    protected $cart;

    /**
     * Construct method
     *
     * @param CartEventDispatcher $cartEventDispatcher Cart EventDispatcher
     * @param CartSessionManager  $cartSessionManager  CartSessionManager
     * @param CartRepository      $cartRepository      Cart Repository
     * @param CartFactory         $cartFactory         Cart Factory
     * @param CustomerWrapper     $customerWrapper     Customer Wrapper
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        CartSessionManager $cartSessionManager,
        CartRepository $cartRepository,
        CartFactory $cartFactory,
        CustomerWrapper $customerWrapper
    )
    {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartSessionManager = $cartSessionManager;
        $this->cartRepository = $cartRepository;
        $this->cartFactory = $cartFactory;
        $this->customerWrapper = $customerWrapper;
    }

    /**
     * Get cart
     *
     * Return current cart value
     *
     * @return CartInterface Instance of Cart loaded
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Load cart
     *
     * This method, first of all tries to retrieve cart from session
     *
     * If this does not exists nor the id is not valid, a new cart is created
     * using Cart factory
     *
     * This behavior can be overridden just overwriting the wrapper
     *
     * @return CartInterface Instance of Cart loaded
     */
    public function loadCart()
    {
        $customer = $this->customerWrapper->loadCustomer();
        $cartFromCustomer = $this->getCustomerCart($customer);
        $cartFromSession = $this->getCartFromSession();

        $this->cart = $this
            ->resolveCarts(
                $customer,
                $cartFromCustomer,
                $cartFromSession
            );

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($this->cart);

        return $this->cart;
    }

    /**
     * Reload cart
     *
     * This method sets to null current cart and tries to load it again
     *
     * @return CartInterface Cart re-loaded
     */
    public function reloadCart()
    {
        $this->cart = null;

        return $this->loadCart();
    }

    /**
     * Return cart from session
     *
     * If session has a cart, retrieves it and checks if exists
     * If exists, returns it
     * Otherwise, creates new one
     * If session has not a cart, creates a new one and returns it
     *
     * @return CartInterface|null Cart
     */
    public function getCartFromSession()
    {
        $cartIdInSession = $this->cartSessionManager->get();

        if (!$cartIdInSession) {
            return null;
        }

        return $this
            ->cartRepository
            ->findOneBy([
                'id'      => $cartIdInSession,
                'ordered' => false,
            ]);
    }

    /**
     * Return customer related cart
     *
     * If customer has any cart related, creates new and returns it
     * Otherwise, retrieves it and saves it to session
     *
     * @param CustomerInterface $customer
     *
     * @return CartInterface Cart
     */
    protected function getCustomerCart(CustomerInterface $customer)
    {
        $customerCart = $customer
            ->getCarts()
            ->filter(function (CartInterface $cart) {
                return !$cart->isOrdered();
            })
            ->first();

        if ($customerCart instanceof CartInterface) {
            return $customerCart;
        }

        return null;
    }

    /**
     * Resolves a cart given a customer cart and a session cart
     *
     * @param CustomerInterface $customer         Customer
     * @param CartInterface     $cartFromCustomer Customer Cart
     * @param CartInterface     $cartFromSession  Cart loaded from session
     *
     * @return CartInterface Cart resolved
     */
    protected function resolveCarts(
        CustomerInterface $customer,
        CartInterface $cartFromCustomer = null,
        CartInterface $cartFromSession = null
    )
    {
        if ($cartFromCustomer) {
            return $cartFromCustomer;
        } else {

            if (!$cartFromSession) {

                /**
                 * Customer has no pending carts, and there is no cart in
                 * session.
                 *
                 * We create a new Cart
                 */
                $cart = $this->cartFactory->create();
            } else {

                /**
                 * Customer has no pending carts, and there is a cart loaded
                 * in session.
                 *
                 * If customer is not a pristine entity since it has already
                 * been flushed, we associate this cart with customer
                 */
                $cart = $cartFromSession;

                if ($customer->getId()) {
                    $cart->setCustomer($customer);
                    $customer->addCart($cart);
                }
            }

            return $cart;
        }
    }
}
