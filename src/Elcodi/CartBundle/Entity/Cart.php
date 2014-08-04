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

namespace Elcodi\CartBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Cart
 */
class Cart extends AbstractEntity implements CartInterface
{
    use DateTimeTrait;

    /**
     * @var CustomerInterface
     *
     * Doctrine mapping must be define in any instance
     */
    protected $customer;

    /**
     * @var OrderInterface
     *
     * The associated order entity. It is a one-one
     * relation and can be null on the Cart side
     */
    protected $order;

    /**
     * @var boolean
     *
     * Ordered
     */
    protected $ordered;

    /**
     * @var Collection
     *
     * Lines
     */
    protected $cartLines;

    /**
     * @var integer
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var MoneyInterface
     *
     * Transient amount for products
     *
     * This value is not persisted, it is calculated
     * by summing CartLine::$productAmount
     */
    protected $productAmount;

    /**
     * @var MoneyInterface
     *
     * Transient amount for coupons
     *
     * This value is not persisted, it is calculated
     * by summing CartLine::$couponAmount
     */
    protected $couponAmount;

    /**
     * @var MoneyInterface
     *
     * Transient total amount
     *
     * This value is not persisted, it is calculated
     * by summing CartLine::$amount
     */
    protected $amount;

    /**
     * Return the customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return Cart self Object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set order
     *
     * @param OrderInterface $order
     *
     * @return Cart self Object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set ordered
     *
     * @param boolean $ordered Has been ordered
     *
     * @return CartInterface self Object
     */
    public function setOrdered($ordered)
    {
        $this->ordered = $ordered;

        return $this;
    }

    /**
     * Is ordered
     *
     * @return boolean is ordered
     */
    public function isOrdered()
    {
        return $this->ordered;
    }

    /**
     * Set cart lines
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return Cart self Object
     */
    public function setCartLines(Collection $cartLines)
    {
        $this->cartLines = $cartLines;

        return $this;
    }

    /**
     * Get lines
     *
     * @return Collection of CartLine
     */
    public function getCartLines()
    {
        return $this->cartLines;
    }

    /**
     * Add Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return Cart self Object
     */
    public function addCartLine(CartLineInterface $cartLine)
    {
        if (!$this->cartLines->contains($cartLine)) {

            $this->cartLines->add($cartLine);
        }

        return $this;
    }

    /**
     * Remove Cart Line
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return Cart self Object
     */
    public function removeCartLine(CartLineInterface $cartLine)
    {
        $this->cartLines->removeElement($cartLine);

        return $this;
    }
    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return Cart self Object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Return the total amount of items
     * added to the Cart
     *
     * @return integer
     */
    public function getTotalItemNumber()
    {
        $totalItems = array_reduce(
            $this->cartLines->toArray(),
            function (CartLineInterface $previous, CartLineInterface $current) {
                return $previous + $current->getQuantity();
            }
        );

        return is_null($totalItems)
            ? 0
            : $totalItems;
    }

    /**
     * Set product amount
     *
     * @param MoneyInterface $productAmount
     *
     * @return CartInterface
     */
    public function setProductAmount(MoneyInterface $productAmount)
    {
        $this->productAmount = $productAmount;

        return $this;
    }

    /**
     * Get product amount
     *
     * @return MoneyInterface Product amount
     */
    public function getProductAmount()
    {
        return $this->productAmount;
    }

    /**
     * Set coupon amount
     *
     * @param MoneyInterface $couponAmount
     *
     * @return CartInterface
     */
    public function setCouponAmount(MoneyInterface $couponAmount)
    {
        $this->couponAmount = $couponAmount;

        return $this;
    }

    /**
     * Get coupon amount
     *
     * @return MoneyInterface Coupon amount
     */
    public function getCouponAmount()
    {
        return $this->couponAmount;
    }

    /**
     * Set amount
     *
     * @param MoneyInterface $amount
     *
     * @return CartInterface
     */
    public function setAmount(MoneyInterface $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return MoneyInterface Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
}
