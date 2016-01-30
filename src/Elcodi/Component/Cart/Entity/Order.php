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

namespace Elcodi\Component\Cart\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\Entity\Traits\PriceTrait;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Payment\Entity\PaymentMethod;
use Elcodi\Component\Product\Entity\Traits\DimensionsTrait;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Order.
 */
class Order implements OrderInterface
{
    use IdentifiableTrait, DateTimeTrait, PriceTrait, DimensionsTrait;

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
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var int
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
     * @var int
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
     * @var ShippingMethod
     *
     * Shipping method
     */
    protected $shippingMethod;

    /**
     * @var array
     *
     * Shipping method extra
     */
    protected $shippingMethodExtra = [];

    /**
     * @var PaymentMethod
     *
     * Payment method
     */
    protected $paymentMethod;

    /**
     * @var array
     *
     * Payment method extra
     */
    protected $paymentMethodExtra = [];

    /**
     * @var AddressInterface
     *
     * delivery address
     */
    protected $deliveryAddress;

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
     * Sets Customer.
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
     * Get Customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set cart.
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
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set order Lines.
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
     * Get order lines.
     *
     * @return Collection Order lines
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * Add order line.
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
     * Remove order line.
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
     * Set quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the Coupon amount with tax.
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
     * Gets the Coupon amount with tax.
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
     * Sets the Shipping amount with tax.
     *
     * @param MoneyInterface $amount shipping amount
     *
     * @return OrderInterface
     */
    public function setShippingAmount(MoneyInterface $amount)
    {
        $this->shippingAmount = $amount->getAmount();
        $this->shippingCurrency = $amount->getCurrency();

        return $this;
    }

    /**
     * Gets the Shipping amount with tax.
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
     * Get ShippingMethod.
     *
     * @return ShippingMethod ShippingMethod
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * Sets ShippingMethod.
     *
     * @param ShippingMethod $shippingMethod ShippingMethod
     *
     * @return $this Self object
     */
    public function setShippingMethod(ShippingMethod $shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    /**
     * Get ShippingMethodExtra.
     *
     * @return array ShippingMethodExtra
     */
    public function getShippingMethodExtra()
    {
        return $this->shippingMethodExtra;
    }

    /**
     * Sets ShippingMethodExtra.
     *
     * @param array $shippingMethodExtra ShippingMethodExtra
     *
     * @return $this Self object
     */
    public function setShippingMethodExtra(array $shippingMethodExtra)
    {
        $this->shippingMethodExtra = $shippingMethodExtra;

        return $this;
    }

    /**
     * Get PaymentMethod.
     *
     * @return PaymentMethod PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Sets PaymentMethod.
     *
     * @param PaymentMethod $paymentMethod PaymentMethod
     *
     * @return $this Self object
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get PaymentMethodExtra.
     *
     * @return array PaymentMethodExtra
     */
    public function getPaymentMethodExtra()
    {
        return $this->paymentMethodExtra;
    }

    /**
     * Sets PaymentMethodExtra.
     *
     * @param array $paymentMethodExtra PaymentMethodExtra
     *
     * @return $this Self object
     */
    public function setPaymentMethodExtra(array $paymentMethodExtra)
    {
        $this->paymentMethodExtra = $paymentMethodExtra;

        return $this;
    }

    /**
     * Get DeliveryAddress.
     *
     * @return AddressInterface DeliveryAddress
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
    }

    /**
     * Sets DeliveryAddress.
     *
     * @param AddressInterface|null $deliveryAddress DeliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress = null)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get PaymentStateLineStack.
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
     * Sets PaymentStateLineStack.
     *
     * @param StateLineStack $paymentStateLineStack PaymentStateLineStack
     *
     * @return $this Self object
     */
    public function setPaymentStateLineStack(StateLineStack $paymentStateLineStack)
    {
        $this->paymentStateLines = $paymentStateLineStack->getStateLines();
        $this->paymentLastStateLine = $paymentStateLineStack->getLastStateLine();

        return $this;
    }

    /**
     * Get ShippingStateLineStack.
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
     * Sets ShippingStateLineStack.
     *
     * @param StateLineStack $shippingStateLineStack ShippingStateLineStack
     *
     * @return $this Self object
     */
    public function setShippingStateLineStack(StateLineStack $shippingStateLineStack)
    {
        $this->shippingStateLines = $shippingStateLineStack->getStateLines();
        $this->shippingLastStateLine = $shippingStateLineStack->getLastStateLine();

        return $this;
    }

    /**
     * Get BillingAddress.
     *
     * @return AddressInterface BillingAddress
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Sets BillingAddress.
     *
     * @param AddressInterface|null $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress(AddressInterface $billingAddress = null)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }
}
