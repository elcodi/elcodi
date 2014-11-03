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

namespace Elcodi\Component\Cart\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Cart
 */
class Cart implements CartInterface
{
    use DateTimeTrait;

    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

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
     * Get Id
     *
     * @return int Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param int $id Id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function setCartLines(Collection $cartLines)
    {
        $this->cartLines = $cartLines;

        return $this;
    }

    /**
     * Get lines
     *
     * @return Collection of CartLines
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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
            function ($previousTotal, CartLineInterface $current) {
                return $previousTotal + $current->getQuantity();
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
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

    /**
     * Return the maximum depth of all the cartLines
     *
     * @return int Depth
     */
    public function getDepth()
    {
        return array_reduce(
            $this->cartLines->toArray(),
            function ($depth, CartLineInterface $cartLine) {
                return max($depth, $cartLine->getDepth());
            },
            0
        );
    }

    /**
     * Return the maximum height of all the cartLines
     *
     * @return int Height
     */
    public function getHeight()
    {
        return array_reduce(
            $this->cartLines->toArray(),
            function ($height, CartLineInterface $cartLine) {
                return max($height, $cartLine->getHeight());
            },
            0
        );
    }

    /**
     * Return the maximum width of all the cartLines
     *
     * @return int Width
     */
    public function getWidth()
    {
        return array_reduce(
            $this->cartLines->toArray(),
            function ($width, CartLineInterface $cartLine) {
                return max($width, $cartLine->getWidth());
            },
            0
        );
    }

    /**
     * Get the sum of all CartLines weight
     *
     * @return int Weight
     */
    public function getWeight()
    {
        return array_reduce(
            $this->cartLines->toArray(),
            function ($weight, CartLineInterface $cartLine) {
                return $weight + $cartLine->getWeight();
            },
            0
        );
    }
}
