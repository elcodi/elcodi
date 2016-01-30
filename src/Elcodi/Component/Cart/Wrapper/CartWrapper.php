<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Wrapper\CustomerWrapper;

/**
 * Class CartWrapper.
 *
 * Envelopes a Cart object and provides the minimum logic to
 * load it from HTTP Session, from the Customer collection
 * of pending Carts or by factoring a pristine Cart.
 *
 * The most useful method in this wrapper is get(), which
 * will behave according to different scenarios:
 *
 * - When the Customer has pending Carts, the last Cart form
 *   this collection is returned
 * - When there is a Cart in session, it is associated with
 *   the Customer and is returned
 * - When there is no Cart in session, a new one is factored
 *
 * Api Methods:
 *
 * * get()
 * * clean()
 *
 * @api
 */
class CartWrapper implements WrapperInterface
{
    /**
     * @var CartEventDispatcher
     *
     * Cart EventDispatcher
     */
    private $cartEventDispatcher;

    /**
     * @var CartFactory
     *
     * Cart Factory
     */
    private $cartFactory;

    /**
     * @var CartSessionWrapper
     *
     * Cart Session Wrapper
     */
    private $cartSessionWrapper;

    /**
     * @var CustomerWrapper
     *
     * CustomerWrapper
     */
    private $customerWrapper;

    /**
     * @var CartInterface
     *
     * Cart loaded
     */
    private $cart;

    /**
     * Construct method.
     *
     * @param CartEventDispatcher $cartEventDispatcher Cart EventDispatcher
     * @param CartFactory         $cartFactory         Cart Factory
     * @param CartSessionWrapper  $cartSessionWrapper  Cart Session Wrapper
     * @param CustomerWrapper     $customerWrapper     Customer Wrapper
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        CartFactory $cartFactory,
        CartSessionWrapper $cartSessionWrapper,
        CustomerWrapper $customerWrapper
    ) {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartFactory = $cartFactory;
        $this->cartSessionWrapper = $cartSessionWrapper;
        $this->customerWrapper = $customerWrapper;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        if ($this->cart instanceof CartInterface) {
            return $this->cart;
        }

        $customer = $this
            ->customerWrapper
            ->get();

        $cartFromCustomer = $this->getCustomerCart($customer);
        $cartFromSession = $this
            ->cartSessionWrapper
            ->get();

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
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        $this->cart = null;

        return $this;
    }

    /**
     * Return customer related cart.
     *
     * If customer has any cart related, creates new and returns it
     * Otherwise, retrieves it and saves it to session
     *
     * @param CustomerInterface $customer
     *
     * @return CartInterface Cart
     */
    private function getCustomerCart(CustomerInterface $customer)
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
     * Resolves a cart given a customer cart and a session cart.
     *
     * @param CustomerInterface  $customer         Customer
     * @param CartInterface|null $cartFromCustomer Customer Cart
     * @param CartInterface|null $cartFromSession  Cart loaded from session
     *
     * @return CartInterface Cart resolved
     */
    private function resolveCarts(
        CustomerInterface $customer,
        CartInterface $cartFromCustomer = null,
        CartInterface $cartFromSession = null
    ) {
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
                $cart = $this
                    ->cartFactory
                    ->create();
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
