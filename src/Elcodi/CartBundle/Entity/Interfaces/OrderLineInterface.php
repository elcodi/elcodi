<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

/**
 * Class OrderLineInterface
 */
interface OrderLineInterface extends PriceInterface
{
    /**
     * Set Order
     *
     * @param OrderInterface $order Order
     *
     * @return OrderLineInterface self Object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * Set the product
     *
     * @param ProductInterface $product Product
     *
     * @return OrderLineInterface self Object
     */
    public function setProduct(ProductInterface $product);

    /**
     * Get the product
     *
     * @return ProductInterface product attached to this cart line
     */
    public function getProduct();

    /**
     * Set quantity
     *
     * @param int $quantity Quantity
     *
     * @return OrderLineInterface self Object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity
     *
     * @return integer Quantity
     */
    public function getQuantity();

    /**
     * Set order line histories
     *
     * @param Collection $orderLineHistories Order histories
     *
     * @return OrderLineInterface self Object
     */
    public function setOrderLineHistories(Collection $orderLineHistories);

    /**
     * Get order line histories
     *
     * @return Collection Order Line histories
     */
    public function getOrderLineHistories();

    /**
     * Add Order History
     *
     * @param OrderLineHistoryInterface $orderLineHistory Order History
     *
     * @return OrderLineInterface self Object
     */
    public function addOrderLineHistory(OrderLineHistoryInterface $orderLineHistory);

    /**
     * Remove Order History
     *
     * @param OrderLineHistoryInterface $orderLineHistory Order Line History
     *
     * @return OrderLineInterface self Object
     */
    public function removeOrderLineHistory(OrderLineHistoryInterface $orderLineHistory);

    /**
     * Sets LastOrderLineHistory
     *
     * @param OrderLineHistoryInterface $lastOrderLineHistory LastOrderLineHistory
     *
     * @return OrderLineInterface Self object
     */
    public function setLastOrderLineHistory(OrderLineHistoryInterface $lastOrderLineHistory);

    /**
     * Get LastOrderLineHistory
     *
     * @return OrderLineHistoryInterface LastOrderLineHistory
     */
    public function getLastOrderLineHistory();
}
