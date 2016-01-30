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

namespace Elcodi\Component\Cart\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;

/**
 * Class CartSaver.
 *
 * Api Methods:
 *
 * * saveCart(CartInterface)
 *
 * @api
 */
class CartSaver
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    private $cartObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $cartObjectManager ObjectManager for Cart
     */
    public function __construct(ObjectManager $cartObjectManager)
    {
        $this->cartObjectManager = $cartObjectManager;
    }

    /**
     * Flushes all loaded cart and related entities.
     *
     * We only persist it if have lines loaded inside, so empty carts will never
     * be persisted
     *
     * @param CartInterface $cart Cart
     */
    public function saveCart(CartInterface $cart)
    {
        if (!$cart->getCartLines()->isEmpty()) {
            $this->cartObjectManager->persist($cart);
        }

        $this
            ->cartObjectManager
            ->flush();
    }
}
