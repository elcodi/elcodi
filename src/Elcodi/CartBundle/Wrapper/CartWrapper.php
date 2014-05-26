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
     * Load cart
     */
    public function loadCart()
    {
        $cartId = $this->cartSessionManager->get();

        $cart = $this
            ->cartRepository
            ->find($cartId);

        if (!($cartId instanceof CartInterface)) {

            $cart = $this->cartFactory->create();
        }

        return $cart;
    }
}
