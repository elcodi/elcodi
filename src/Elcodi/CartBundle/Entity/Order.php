<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface;
use Elcodi\CartBundle\Entity\Traits\PriceTrait;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;

/**
 * Order
 */
class Order extends AbstractEntity implements OrderInterface
{
    use DateTimeTrait, PriceTrait;

    /**
     * @var integer
     *
     * Coupon Amount
     */
    protected $couponAmount;

    /**
     * @var CustomerInterface
     *
     * Customer
     */
    protected $customer;

    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var Collection
     *
     * Order Lines
     */
    protected $orderLines;

    /**
     * @var Collection
     *
     * Order histories
     */
    protected $orderHistories;

    /**
     * @var integer
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var OrderHistoryInterface
     *
     * Last OrderHistory
     */
    protected $lastOrderHistory;

    /**
     * Sets Customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return Order Self object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get Customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set cart
     *
     * @param CartInterface $cart Cart
     *
     * @return Order Self object
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return Order self Object
     */
    public function setOrderLines(Collection $orderLines)
    {
        $this->orderLines = $orderLines;

        return $this;
    }

    /**
     * Get order lines
     *
     * @return Collection Order lines
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * Add order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return Order self Object
     */
    public function addOrderLine(OrderLineInterface $orderLine)
    {
        $this->orderLines->add($orderLine);

        return $this;
    }

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return Order self Object
     */
    public function removeOrderLine(OrderLineInterface $orderLine)
    {
        $this->orderLines->removeElement($orderLine);

        return $this;
    }

    /**
     * Set order histories
     *
     * @param Collection $orderHistories Order histories
     *
     * @return Order self Object
     */
    public function setOrderHistories(Collection $orderHistories)
    {
        $this->orderHistories = $orderHistories;

        return $this;
    }

    /**
     * Get order histories
     *
     * @return Collection Order histories
     */
    public function getOrderHistories()
    {
        return $this->orderHistories;
    }

    /**
     * Add Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return Order self Object
     */
    public function addOrderHistory(OrderHistoryInterface $orderHistory)
    {
        $this->orderHistories->add($orderHistory);

        return $this;
    }

    /**
     * Remove Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return Order self Object
     */
    public function removeOrderHistory(OrderHistoryInterface $orderHistory)
    {
        $this->orderHistories->removeElement($orderHistory);

        return $this;
    }
    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return Order self Object
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
     * Sets LastOrderHistory
     *
     * @param OrderHistoryInterface $lastOrderHistory LastOrderHistory
     *
     * @return Order Self object
     */
    public function setLastOrderHistory(OrderHistoryInterface $lastOrderHistory)
    {
        $this->lastOrderHistory = $lastOrderHistory;

        return $this;
    }

    /**
     * Get LastOrderHistory
     *
     * @return OrderHistoryInterface LastOrderHistory
     */
    public function getLastOrderHistory()
    {
        return $this->lastOrderHistory;
    }

    /**
     * Gets the Coupon amount with tax
     *
     * @return Money
     */
    public function getCouponAmount()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return new Money($this->couponAmount, $this->currency);
        }

        return null;
    }

    /**
     * Sets the Coupon amount with tax
     *
     * @param MoneyInterface $couponAmount coupon amount
     *
     * @return OrderInterface
     */
    public function setCouponAmount(MoneyInterface $couponAmount = null)
    {
        if ($couponAmount instanceof MoneyInterface) {
            $this->couponAmount = $couponAmount->getAmount();
        }

        return $this;
    }
}
