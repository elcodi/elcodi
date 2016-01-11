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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;

/**
 * Class CartPurchasablesQuantityLoader.
 *
 * Api Methods:
 *
 * * loadCartPurchasablesQuantities(CartInterface)
 *
 * @api
 */
class CartPurchasablesQuantityLoader
{
    /**
     * Calculates and load how many purchasables has this cart.
     *
     * @param CartInterface $cart Cart
     */
    public function loadCartPurchasablesQuantities(CartInterface $cart)
    {
        $quantity = 0;

        /**
         * Calculate max shipping delay.
         */
        foreach ($cart->getCartLines() as $cartLine) {

            /**
             * @var CartLineInterface $cartLine
             */
            $quantity += $cartLine->getQuantity();
        }

        $cart->setQuantity($quantity);
    }
}
