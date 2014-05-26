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

namespace Elcodi\CartBundle\Wrapper;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Factory\CartFactory;
use Elcodi\CartBundle\Repository\CartRepository;
use Elcodi\CartBundle\Services\CartSessionManager;

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
     */
    public function __construct(
        CartSessionManager $cartSessionManager,
        CartRepository $cartRepository,
        CartFactory $cartFactory
    )
    {
        $this->cartSessionManager = $cartSessionManager;
        $this->cartRepository = $cartRepository;
        $this->cartFactory = $cartFactory;
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
        if ($this->cart instanceof CartInterface) {

            return $this->cart;
        }

        $cartId = $this->cartSessionManager->get();

        if ($cartId) {
            $this->cart = $this
                ->cartRepository
                ->find($cartId);
        }

        if (!($this->cart instanceof CartInterface)) {

            $this->cart = $this->cartFactory->create();
        }

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
}
