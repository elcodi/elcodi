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

namespace Elcodi\Component\Cart\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Class CartFactory.
 */
class CartFactory extends AbstractPurchasableFactory
{
    /**
     * Creates an instance of Cart.
     *
     * Cart factory does not need to known about Currency
     * objects in order to initialize Money objects for
     * properties such as Cart::amount, Cart::purchasableAmount
     * and Cart::couponAmount since they are meant to be
     * set by event listeners.
     *
     * @see Elcodi\Component\Cart\EventListener\CartEventListener::loadCartPrices()
     *
     * @return Cart New Cart entity
     */
    public function create()
    {
        /**
         * @var Cart $cart
         */
        $classNamespace = $this->getEntityNamespace();
        $cart = new $classNamespace();
        $cart
            ->setOrdered(false)
            ->setCartLines(new ArrayCollection())
            ->setPurchasableAmount($this->createZeroAmountMoney())
            ->setAmount($this->createZeroAmountMoney())
            ->setCouponAmount($this->createZeroAmountMoney())
            ->setShippingAmount($this->createZeroAmountMoney())
            ->setCreatedAt($this->now());

        return $cart;
    }
}
