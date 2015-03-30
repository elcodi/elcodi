<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class CartFactory
 */
class CartFactory extends AbstractFactory
{
    /**
     * Creates an instance of Cart
     *
     * Cart factory does not need to known about Currency
     * objects in order to initialize Money objects for
     * properties such as Cart::amount, Cart::productAmount
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
            ->setQuantity(0)
            ->setOrdered(false)
            ->setCartLines(new ArrayCollection())
            ->setCreatedAt(new DateTime());

        return $cart;
    }
}
