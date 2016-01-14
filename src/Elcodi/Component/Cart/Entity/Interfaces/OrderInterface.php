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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Payment\Entity\PaymentMethod;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Interface OrderInterface.
 */
interface OrderInterface
    extends
    PriceInterface,
    DimensionableInterface,
    IdentifiableInterface
{
    /**
     * Sets Customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this Self object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get Customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Set cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart();

    /**
     * Set order Lines.
     *
     * @param Collection $orderLines Order lines
     *
     * @return $this Self object
     */
    public function setOrderLines(Collection $orderLines);

    /**
     * Get order lines.
     *
     * @return Collection Order lines
     */
    public function getOrderLines();

    /**
     * Add order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity.
     *
     * @return int Quantity
     */
    public function getQuantity();

    /**
     * Gets the Coupon amount with tax.
     *
     * @return MoneyInterface
     */
    public function getCouponAmount();

    /**
     * Sets the Coupon amount with tax.
     *
     * @param MoneyInterface $couponAmount coupon amount
     *
     * @return $this
     */
    public function setCouponAmount(MoneyInterface $couponAmount);

    /**
     * Gets the shipping amount.
     *
     * @return MoneyInterface Shipping amount with tax
     */
    public function getShippingAmount();

    /**
     * Sets the shipping amount.
     *
     * @param MoneyInterface $shippingAmount shipping amount with tax
     *
     * @return $this Self object
     */
    public function setShippingAmount(MoneyInterface $shippingAmount);

    /**
     * Get ShippingMethod.
     *
     * @return ShippingMethod ShippingMethod
     */
    public function getShippingMethod();

    /**
     * Sets ShippingMethod.
     *
     * @param ShippingMethod $shippingMethod ShippingMethod
     *
     * @return $this Self object
     */
    public function setShippingMethod(ShippingMethod $shippingMethod);

    /**
     * Get ShippingMethodExtra.
     *
     * @return array ShippingMethodExtra
     */
    public function getShippingMethodExtra();

    /**
     * Sets ShippingMethodExtra.
     *
     * @param array $shippingMethodExtra ShippingMethodExtra
     *
     * @return $this Self object
     */
    public function setShippingMethodExtra(array $shippingMethodExtra);

    /**
     * Get PaymentMethod.
     *
     * @return PaymentMethod PaymentMethod
     */
    public function getPaymentMethod();

    /**
     * Sets PaymentMethod.
     *
     * @param PaymentMethod $paymentMethod PaymentMethod
     *
     * @return $this Self object
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod);

    /**
     * Get PaymentMethodExtra.
     *
     * @return array PaymentMethodExtra
     */
    public function getPaymentMethodExtra();

    /**
     * Sets PaymentMethodExtra.
     *
     * @param array $paymentMethodExtra PaymentMethodExtra
     *
     * @return $this Self object
     */
    public function setPaymentMethodExtra(array $paymentMethodExtra);

    /**
     * Set the height.
     *
     * @param int $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width.
     *
     * @param int $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth.
     *
     * @param int $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight.
     *
     * @param int $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);

    /**
     * Get DeliveryAddress.
     *
     * @return AddressInterface DeliveryAddress
     */
    public function getDeliveryAddress();

    /**
     * Sets DeliveryAddress.
     *
     * @param AddressInterface $deliveryAddress DeliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress(AddressInterface $deliveryAddress);

    /**
     * Get PaymentStateLineStack.
     *
     * @return StateLineStack PaymentStateLineStack
     */
    public function getPaymentStateLineStack();

    /**
     * Sets PaymentStateLineStack.
     *
     * @param StateLineStack $paymentStateLineStack PaymentStateLineStack
     *
     * @return $this Self object
     */
    public function setPaymentStateLineStack(
        StateLineStack $paymentStateLineStack
    );

    /**
     * Get ShippingStateLineStack.
     *
     * @return StateLineStack ShippingStateLineStack
     */
    public function getShippingStateLineStack();

    /**
     * Sets ShippingStateLineStack.
     *
     * @param StateLineStack $shippingStateLineStack ShippingStateLineStack
     *
     * @return $this Self object
     */
    public function setShippingStateLineStack(
        StateLineStack $shippingStateLineStack
    );

    /**
     * Get BillingAddress.
     *
     * @return AddressInterface BillingAddress
     */
    public function getBillingAddress();

    /**
     * Sets BillingAddress.
     *
     * @param AddressInterface $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress(AddressInterface $billingAddress);
}
