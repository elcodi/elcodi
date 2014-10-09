<?php

/**
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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Abstracts\AbstractLine;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Resolver\DefaultPurchasableResolver;
use Elcodi\Component\Cart\Resolver\Interfaces\PurchasableResolverInterface;

/**
 * Cart line
 */
class CartLine extends AbstractLine implements CartLineInterface
{
    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var OrderLineInterface
     *
     * Order Line
     */
    protected $orderLine;

    /**
     * Set Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return $this self Object
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Sets OrderLine
     *
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return CartLine Self object
     */
    public function setOrderLine($orderLine)
    {
        $this->orderLine = $orderLine;

        return $this;
    }

    /**
     * Get OrderLine
     *
     * @return OrderLineInterface OrderLine
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }

    /**
     * Returns a purchasable resolver
     *
     * A purchasable resolver is needed so that classes in the
     * hierarchy can plug-in specific logic when adding a
     * Purchasable to an AbstractLine
     *
     * Here we will return the Default resolver
     *
     * @return PurchasableResolverInterface
     */
    protected function getPurchasableResolver()
    {
        return new DefaultPurchasableResolver($this);
    }

    /**
     * Return the purchasable object depth
     *
     * @return int Depth
     */
    public function getDepth()
    {
        return $this
            ->getPurchasable()
            ->getDepth();
    }

    /**
     * Return the purchasable object height
     *
     * @return int Height
     */
    public function getHeight()
    {
        return $this
            ->getPurchasable()
            ->getHeight();
    }

    /**
     * Return the purchasable object width
     *
     * @return int Width
     */
    public function getWidth()
    {
        return $this
            ->getPurchasable()
            ->getWidth();
    }

    /**
     * Return the purchasable object weight
     *
     * @return int Weight
     */
    public function getWeight()
    {
        return $this
            ->getPurchasable()
            ->getWeight();
    }
}
