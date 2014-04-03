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

namespace Elcodi\CartBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\CartBundle\Entity\Interfaces\PriceInterface;

/**
 * Class OrderInterface
 */
interface OrderInterface extends PriceInterface
{
    /**
     * Sets Customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return OrderInterface Self object
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
     * @return OrderInterface Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart
     *
     * @return OrderInterface self Object
     */
    public function getCart();

    /**
     * Set order Lines
     *
     * @param Collection $orderLines Order lines
     *
     * @return OrderInterface self Object
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
     * @return OrderInterface self Object
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return OrderInterface self Object
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set order histories
     *
     * @param Collection $orderHistories Order histories
     *
     * @return OrderInterface self Object
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
     * @return OrderInterface self Object
     */
    public function addOrderHistory(OrderHistoryInterface $orderHistory);

    /**
     * Remove Order History
     *
     * @param OrderHistoryInterface $orderHistory Order History
     *
     * @return OrderInterface self Object
     */
    public function removeOrderHistory(OrderHistoryInterface $orderHistory);

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return OrderInterface self Object
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
     * @return OrderInterface Self object
     */
    public function setLastOrderHistory(OrderHistoryInterface $lastOrderHistory);

    /**
     * Get LastOrderHistory
     *
     * @return OrderHistoryInterface LastOrderHistory
     */
    public function getLastOrderHistory();
}
