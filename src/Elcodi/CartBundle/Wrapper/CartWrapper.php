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

namespace Elcodi\CartBundle\Wrapper;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\EventDispatcher\CartEventDispatcher;
use Elcodi\CartBundle\Factory\CartFactory;
use Elcodi\CartBundle\Repository\CartRepository;
use Elcodi\CartBundle\Services\CartSessionManager;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\UserBundle\Wrapper\CustomerWrapper;

/**
 * Class CartWrapper
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
     *
     * @api
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
     * This behavior can be overriden just overwritting the wrapper
     *
     * @return CartInterface Instance of Cart loaded
     *
     * @api
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
     *
     * @api
     */
    public function reloadCart()
    {
        $this->cart = null;

        return $this->loadCart();
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
            ->first();

        if ($customerCart instanceof CartInterface) {
            return $customerCart;
        }

        return null;
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
            ->find($cartIdInSession);
    }

    /**
     * Resolve carts given customer cart and session cart
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
                 * Customer has any cart not ordered, and there is no cart in
                 * session.
                 *
                 * We create a new Cart
                 */
                $cart = $this->cartFactory->create();
            } else {

                /**
                 * Customer has any cart not ordered, and there is a cart loaded
                 * in session.
                 *
                 * If customer exists as a persisted entity, we save this cart
                 * as Customer cart
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
