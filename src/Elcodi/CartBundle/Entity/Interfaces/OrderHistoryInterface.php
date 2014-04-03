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

/**
 * Class OrderHistoryInterface
 */
interface OrderHistoryInterface
{
    /**
     * Set the order
     *
     * @param OrderInterface $order Order to set
     *
     * @return OrderHistoryInterface self Object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get the order
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Set state
     *
     * @param string $state State
     *
     * @return OrderHistoryInterface self Object
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
     * @return OrderHistoryInterface self Object
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();
}
