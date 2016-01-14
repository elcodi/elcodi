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
use Elcodi\Component\Currency\Entity\Money;

/**
 * Class CartAmountValidator.
 *
 * Api Methods:
 *
 * * validateAmount(CartInterface)
 * * validateNegativeAmount(CartInterface)
 *
 * @api
 */
class CartAmountValidator
{
    /**
     * When a cart goes below 0 (due to discounts), set the amount to 0.
     *
     * @param CartInterface $cart Cart
     */
    public function validateAmount(CartInterface $cart)
    {
        $this->validateNegativeAmount($cart);
    }

    /**
     * When a cart goes below 0 (due to discounts), set the amount to 0.
     *
     * @param CartInterface $cart Cart
     */
    public function validateNegativeAmount(CartInterface $cart)
    {
        $amount = $cart->getAmount();

        if ($amount->getAmount() <= 0) {
            $cart
                ->setAmount(Money::create(
                    0,
                    $amount->getCurrency()
                ));
        }
    }
}
