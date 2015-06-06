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
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Order
 */
class Order implements OrderInterface
{
    use DateTimeTrait, PriceTrait, DimensionsTrait;

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
     * Coupon Currency
     */
    protected $couponCurrency;

    /**
     * @var integer
     *
     * Shipping Amount
     */
    protected $shippingAmount;

    /**
     * @var CurrencyInterface
     *
     * Shipping Currency
     */
    protected $shippingCurrency;

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
     * @var StateLineInterface
     *
     * Last stateLine in payment stateLine stack
     */
    protected $paymentLastStateLine;

    /**
     * @var StateLineInterface
     *
     * Last stateLine in shipping stateLine stack
     */
    protected $shippingLastStateLine;

    /**
     * @var Collection
     *
     * StateLines for payment
     */
    protected $paymentStateLines;

    /**
     * @var Collection
     *
     * StateLines for shipping
     */
    protected $shippingStateLines;

    /**
     * @var AddressInterface
     *
     * billing address
     */
    protected $billingAddress;

    /**
     * @var integer
     *
     * Tax amount
     */
    protected $taxAmount;

    /**
     * Get Id
     *
     * @return integer Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Id
     *
     * @param integer $id Id
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
     * @return $this Self object
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
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function removeOrderLine(OrderLineInterface $orderLine)
    {
        $this->orderLines->removeElement($orderLine);

        return $this;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity Quantity
     *
     * @return $this Self object
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
        $this->couponAmount   = $amount->getAmount();
        $this->couponCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the Coupon amount with tax
     *
     * @return MoneyInterface Coupon amount
     */
    public function getCouponAmount()
    {
        return Money::create(
            $this->couponAmount,
            $this->couponCurrency
        );
    }

    /**
     * Sets the Shipping amount with tax
     *
     * @param MoneyInterface $amount shipping amount
     *
     * @return OrderInterface
     */
    public function setShippingAmount(MoneyInterface $amount)
    {
        $this->shippingAmount   = $amount->getAmount();
        $this->shippingCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the Shipping amount with tax
     *
     * @return MoneyInterface Shipping amount
     */
    public function getShippingAmount()
    {
        return Money::create(
            $this->shippingAmount,
            $this->shippingCurrency
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

    /**
     * Get PaymentStateLineStack
     *
     * @return StateLineStack PaymentStateLineStack
     */
    public function getPaymentStateLineStack()
    {
        return StateLineStack::create(
            $this->paymentStateLines,
            $this->paymentLastStateLine
        );
    }

    /**
     * Sets PaymentStateLineStack
     *
     * @param StateLineStack $paymentStateLineStack PaymentStateLineStack
     *
     * @return $this Self object
     */
    public function setPaymentStateLineStack(
        StateLineStack $paymentStateLineStack
    ) {
        $this->paymentStateLines    = $paymentStateLineStack->getStateLines();
        $this->paymentLastStateLine = $paymentStateLineStack->getLastStateLine();

        return $this;
    }

    /**
     * Get ShippingStateLineStack
     *
     * @return StateLineStack ShippingStateLineStack
     */
    public function getShippingStateLineStack()
    {
        return StateLineStack::create(
            $this->shippingStateLines,
            $this->shippingLastStateLine
        );
    }

    /**
     * Sets ShippingStateLineStack
     *
     * @param StateLineStack $shippingStateLineStack ShippingStateLineStack
     *
     * @return $this Self object
     */
    public function setShippingStateLineStack(
        StateLineStack $shippingStateLineStack
    ) {
        $this->shippingStateLines    = $shippingStateLineStack->getStateLines();
        $this->shippingLastStateLine = $shippingStateLineStack->getLastStateLine();

        return $this;
    }

    /**
     * Get BillingAddress
     *
     * @return AddressInterface BillingAddress
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Sets BillingAddress
     *
     * @param AddressInterface $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Set taxAmount
     * Notice that the currency of taxAmount is the same as the currency for amount
     *
     * @param MoneyInterface $taxAmount
     *
     * @return $this Self object
     */
    public function setTaxAmount(MoneyInterface $taxAmount)
    {
        $this->taxAmount = $taxAmount->getAmount();

        return $this;
    }

    /**
     * Get taxAmount
     * Notice that the currency of taxAmount is the same as the currency for amount
     *
     * @return MoneyInterface
     */
    public function getTaxAmount()
    {
        return Money::create(
            $this->taxAmount,
            $this->currency
        );
    }
}
