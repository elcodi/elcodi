<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Shipping\Event;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;

/**
 * Class ShippingCollectionEvent
 */
interface ShippingCollectionEventInterface
{
    /**
     * Get cart
     *
     * @return CartInterface $cart
     */
    public function getCart();

    /**
     * Add shipping method
     *
     * @param ShippingMethod $shippingMethod Shipping method
     *
     * @return $this Self object
     */
    public function addShippingMethod(ShippingMethod $shippingMethod);

    /**
     * Get shipping methods
     *
     * @return ShippingMethod[] Shipping methods
     */
    public function getShippingMethods();
}
