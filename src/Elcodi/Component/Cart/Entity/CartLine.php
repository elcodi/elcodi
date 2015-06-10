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

namespace Elcodi\Component\Cart\Entity;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Cart\Entity\Traits\PurchasableWrapperTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Tax\Entity\Traits\TaxTrait;

/**
 * Cart line
 */
class CartLine implements CartLineInterface
{
    use IdentifiableTrait,
        PurchasableWrapperTrait,
        PriceTrait;

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
     * @var float
     *
     * Tax percentage applied to the product
     * This value is not persisted
     */
    protected $taxPercentage;

    /**
     * Set Cart
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
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
     * @return $this Self object
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
     * Return the purchasable object depth
     *
     * @return integer Depth
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
     * @return integer Height
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
     * @return integer Width
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
     * @return integer Weight
     */
    public function getWeight()
    {
        return $this->quantity * $this
            ->getPurchasable()
            ->getWeight();
    }
}
