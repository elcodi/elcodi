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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;

/**
 * Interface CartLineInterface.
 */
interface CartLineInterface
    extends
    IdentifiableInterface,
    PurchasableWrapperInterface,
    PriceInterface,
    DimensionableInterface
{
    /**
     * Set Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart.
     *
     * @return CartInterface
     */
    public function getCart();

    /**
     * Sets OrderLine.
     *
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return $this Self object
     */
    public function setOrderLine(OrderLineInterface $orderLine);

    /**
     * Get OrderLine.
     *
     * @return OrderLineInterface OrderLine
     */
    public function getOrderLine();
}
