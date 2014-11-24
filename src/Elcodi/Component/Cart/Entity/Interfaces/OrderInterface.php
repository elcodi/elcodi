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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StatefulInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class OrderInterface
 */
interface OrderInterface extends PriceInterface, DimensionableInterface, StatefulInterface
{
    /**
     * Sets Customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return self
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
     * @return self
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart
     *
     * @return self
     */
    public function getCart();

    /**
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return self
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
     * @return self
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return self
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return self
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
     * @return self
     */
    public function setCouponAmount(MoneyInterface $couponAmount);

    /**
     * Set the height
     *
     * @param integer $height Height
     *
     * @return self
     */
    public function setHeight($height);

    /**
     * Set the width
     *
     * @param integer $width Width
     *
     * @return self
     */
    public function setWidth($width);

    /**
     * Set the depth
     *
     * @param integer $depth Depth
     *
     * @return self
     */
    public function setDepth($depth);

    /**
     * Set the weight
     *
     * @param integer $weight Weight
     *
     * @return self
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
     * @return self
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
     * @return self
     */
    public function setDeliveryAddress($deliveryAddress);
}
