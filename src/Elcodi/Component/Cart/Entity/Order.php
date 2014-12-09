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
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\StateTransitionMachine\Entity\Traits\StateLinesTrait;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Order
 */
class Order implements OrderInterface
{
    use DateTimeTrait, PriceTrait, DimensionsTrait, StateLinesTrait;

    /**
     * @var integer
     *
     * Identifier
     */
    protected $id;

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
     * @var integer
     *
     * Quantity
     */
    protected $quantity;

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
