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
     * @param CartSessionManager $cartSessionManager CartSessionManager
     * @param CartRepository     $cartRepository     Cart Repository
     * @param CartFactory        $cartFactory        Cart Factory
     * @param CustomerWrapper    $customerWrapper    Customer Wrapper
     */
    public function __construct(
        CartSessionManager $cartSessionManager,
        CartRepository $cartRepository,
        CartFactory $cartFactory,
        CustomerWrapper $customerWrapper
    )
    {
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

        $this->cart = $customer->getId()
            ? $this->getCustomerCart($customer)
            : $this->getCartFromSession();

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
        $cart = $customer
            ->getCarts()
            ->last();

        if (($cart instanceof CartInterface) && !$cart->isOrdered()) {

            $this
                ->cartSessionManager
                ->set($cart);

            return $cart;
        }

        $cart = $this->cartFactory->create();
        $cart->setCustomer($customer);

        return $cart;
    }

    /**
     * Return cart from session
     *
     * If session has a cart, retrieves it and checks if exists
     * If exists, returns it
     * Otherwise, creates new one
     * If session has not a cart, creates a new one and returns it
     *
     * @return CartInterface Cart
     */
    public function getCartFromSession()
    {
        $cartIdInSession = $this->cartSessionManager->get();

        if (!$cartIdInSession) {
            return $this->cartFactory->create();
        }

        $cart = $this
            ->cartRepository
            ->find($cartIdInSession);

        return ($cart instanceof CartInterface)
            ? $cart
            : $this->cartFactory->create();
    }
}
