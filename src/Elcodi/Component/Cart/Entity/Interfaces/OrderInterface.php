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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class OrderInterface
 */
interface OrderInterface extends PriceInterface, DimensionableInterface
{
    /**
     * Sets Customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this Self object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get Customer
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Set cart
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart
     *
     * @return CartInterface Cart
     */
    public function getCart();

    /**
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return $this Self object
     */
    public function setOrderLines(Collection $orderLines);

    /**
     * Get order lines
     *
     * @return Collection Order lines
     */
    public function getOrderLines();

    /**
     * Add order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity();

    /**
     * Gets the Coupon amount with tax
     *
     * @return MoneyInterface
     */
    public function getCouponAmount();

    /**
     * Sets the Coupon amount with tax
     *
     * @param MoneyInterface $couponAmount coupon amount
     *
     * @return $this
     */
    public function setCouponAmount(MoneyInterface $couponAmount);

    /**
     * Set the height
     *
     * @param integer $height Height
     *
     * @return $this Self object
     */
    public function setHeight($height);

    /**
     * Set the width
     *
     * @param integer $width Width
     *
     * @return $this Self object
     */
    public function setWidth($width);

    /**
     * Set the depth
     *
     * @param integer $depth Depth
     *
     * @return $this Self object
     */
    public function setDepth($depth);

    /**
     * Set the weight
     *
     * @param integer $weight Weight
     *
     * @return $this Self object
     */
    public function setWeight($weight);

    /**
     * Get InvoiceAddress
     *
     * @return AddressInterface InvoiceAddress
     */
    public function getInvoiceAddress();

    /**
     * Sets InvoiceAddress
     *
     * @param AddressInterface $invoiceAddress InvoiceAddress
     *
     * @return $this Self object
     */
    public function setInvoiceAddress($invoiceAddress);

    /**
     * Get DeliveryAddress
     *
     * @return AddressInterface DeliveryAddress
     */
    public function getDeliveryAddress();

    /**
     * Sets DeliveryAddress
     *
     * @param AddressInterface $deliveryAddress DeliveryAddress
     *
     * @return $this Self object
     */
    public function setDeliveryAddress($deliveryAddress);

    /**
     * Get PaymentStateLineStack
     *
     * @return StateLineStack PaymentStateLineStack
     */
    public function getPaymentStateLineStack();

    /**
     * Sets PaymentStateLineStack
     *
     * @param StateLineStack $paymentStateLineStack PaymentStateLineStack
     *
     * @return $this Self object
     */
    public function setPaymentStateLineStack(
        StateLineStack $paymentStateLineStack
    );

    /**
     * Get ShippingStateLineStack
     *
     * @return StateLineStack ShippingStateLineStack
     */
    public function getShippingStateLineStack();

    /**
     * Sets ShippingStateLineStack
     *
     * @param StateLineStack $shippingStateLineStack ShippingStateLineStack
     *
     * @return $this Self object
     */
    public function setShippingStateLineStack(
        StateLineStack $shippingStateLineStack
    );

    /**
     * Get BillingAddress
     *
     * @return AddressInterface BillingAddress
     */
    public function getBillingAddress();

    /**
     * Sets BillingAddress
     *
     * @param AddressInterface $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress($billingAddress);
}
