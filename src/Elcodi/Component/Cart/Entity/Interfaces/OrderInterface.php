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

namespace Elcodi\Component\Cart\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Product\Entity\Interfaces\DimensionableInterface;
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
     * @return $this self Object
     */
    public function getCart();

    /**
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return $this self Object
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
     * @return $this self Object
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this self Object
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set order histories
     *
     * @param Collection $orderHistories Order histories
     *
     * @return $this self Object
     */
    public function setOrderHistories(Collection $orderHistories);

    /**
     * Get order histories
     *
     * @return Collection Order histories
     */
    public function getOrderHistories();

    /**
     * Add Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return $this self Object
     */
    public function addOrderHistory(OrderHistoryInterface $orderHistory);

    /**
     * Remove Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return $this self Object
     */
    public function removeOrderHistory(OrderHistoryInterface $orderHistory);

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return $this self Object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity();

    /**
     * Sets LastOrderHistory
     *
     * @param OrderHistoryInterface $lastOrderHistory LastOrderHistory
     *
     * @return $this Self object
     */
    public function setLastOrderHistory(OrderHistoryInterface $lastOrderHistory);

    /**
     * Get LastOrderHistory
     *
     * @return OrderHistoryInterface LastOrderHistory
     */
    public function getLastOrderHistory();

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
     * @return $this self Object
     */
    public function setHeight($height);

    /**
     * Set the width
     *
     * @param integer $width Width
     *
     * @return $this self Object
     */
    public function setWidth($width);

    /**
     * Set the depth
     *
     * @param integer $depth Depth
     *
     * @return $this self Object
     */
    public function setDepth($depth);

    /**
     * Set the weight
     *
     * @param integer $weight Weight
     *
     * @return $this self Object
     */
    public function setWeight($weight);
}
