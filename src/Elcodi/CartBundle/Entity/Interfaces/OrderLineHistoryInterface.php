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

/**
 * Class OrderLineHistoryInterface
 */
interface OrderLineHistoryInterface
{
    /**
     * Set order line
     *
     * @param OrderLineInterface $orderLine Order Line
     *
     * @return OrderLineHistoryInterface self Object
     */
    public function setOrderLine(OrderLineInterface $orderLine);

    /**
     * Get the order line
     *
     * @return OrderLineInterface
     */
    public function getOrderLine();

    /**
     * Set state
     *
     * @param string $state State
     *
     * @return OrderLineHistoryInterface self Object
     */
    public function setState($state);

    /**
     * Get state
     *
     * @return string State
     */
    public function getState();

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return OrderLineHistoryInterface self Object
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();
}
