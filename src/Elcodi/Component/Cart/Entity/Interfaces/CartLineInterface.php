<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;

/**
 * Class CartLineInterface
 */
interface CartLineInterface
    extends
    IdentifiableInterface,
    PurchasableWrapperInterface,
    PriceInterface,
    DimensionableInterface
{
    /**
     * Set Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return $this self Object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart
     *
     * @return CartInterface
     */
    public function getCart();

    /**
     * Sets OrderLine
     *
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return CartLineInterface Self object
     */
    public function setOrderLine($orderLine);

    /**
     * Get OrderLine
     *
     * @return OrderLineInterface OrderLine
     */
    public function getOrderLine();
}
