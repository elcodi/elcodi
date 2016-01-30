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
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper;

/**
 * Class CartShippingAmountValidator.
 *
 * Api Methods:
 *
 * * validateEmptyShippingAmount(CartInterface)
 *
 * @api
 */
class CartShippingAmountValidator
{
    /**
     * @var EmptyMoneyWrapper
     *
     * Empty Money Wrapper
     */
    private $emptyMoneyWrapper;

    /**
     * Construct.
     *
     * @param EmptyMoneyWrapper $emptyMoneyWrapper Empty money wrapper
     */
    public function __construct(EmptyMoneyWrapper $emptyMoneyWrapper)
    {
        $this->emptyMoneyWrapper = $emptyMoneyWrapper;
    }

    /**
     * If the cart's shipping amount is not defined, then put an empty Money
     * value.
     *
     * @param CartInterface $cart Cart
     */
    public function validateEmptyShippingAmount(CartInterface $cart)
    {
        $shippingAmount = $cart->getShippingAmount();
        if (!($shippingAmount instanceof MoneyInterface)) {
            $cart
                ->setShippingAmount(
                    $this
                        ->emptyMoneyWrapper
                        ->get()
                );
        }
    }
}
