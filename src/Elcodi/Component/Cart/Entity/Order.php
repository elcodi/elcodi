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
use Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Order
 */
class Order extends AbstractEntity implements OrderInterface
{
    use DateTimeTrait, PriceTrait, DimensionsTrait;

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
     * @var integer
     *
     * Coupon Amount
     */
    protected $couponAmount;

    /**
     * @var CurrencyInterface
     *
     * Coupon Amount
     */
    protected $couponCurrency;

    /**
     * @var AddressInterface
     *
     * delivery address
     */
    protected $deliveryAddress;

    /**
     * @var AddressInterface
     *
     * invoice address
     */
    protected $invoiceAddress;

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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addOrderLine(OrderLineInterface $orderLine)
    {
        if (!$this->orderLines->contains($orderLine)) {

            $this->orderLines->add($orderLine);
        }

        return $this;
    }

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addOrderHistory(OrderHistoryInterface $orderHistory)
    {
        if (!$this->orderLines->contains($orderHistory)) {

            $this->orderHistories->add($orderHistory);
        }

        return $this;
    }

    /**
     * Remove Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return $this self Object
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
     * Sets the Coupon amount with tax
     *
     * @param MoneyInterface $amount coupon amount
     *
     * @return OrderInterface
     */
    public function setCouponAmount(MoneyInterface $amount)
    {
        $this->couponAmount = $amount->getAmount();
        $this->couponCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the Coupon amount with tax
     *
     * @return Money
     */
    public function getCouponAmount()
    {
        return Money::create(
            $this->couponAmount,
            $this->couponCurrency
        );
    }

    /**
     * Get InvoiceAddress
     *
     * @return AddressInterface InvoiceAddress
     */
    public function getInvoiceAddress()
    {
        return $this->invoiceAddress;
    }

    /**
     * Sets InvoiceAddress
     *
     * @param AddressInterface $invoiceAddress InvoiceAddress
     *
     * @return $this Self object
     */
    public function setInvoiceAddress($invoiceAddress)
    {
        $this->invoiceAddress = $invoiceAddress;

        return $this;
    }

    /**
     * Get DeliveryAddress
     *
     * @return AddressInterface DeliveryAddress
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Sets DeliveryAddress
     *
     * @param AddressInterface $deliveryAddress DeliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }
}
