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

namespace Elcodi\CartBundle\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Event\Abstracts\AbstractOrderStateEvent;

/**
 * Event fired when a new state is added into OrderHistory
 */
class OrderStatePostChangeEvent extends AbstractOrderStateEvent
{
    /**
     * @var OrderHistoryInterface
     *
     * Current OrderHistory object
     */
    protected $orderHistory;

    /**
     * construct method
     *
     * @param OrderInterface        $order            Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     * @param OrderHistoryInterface $orderHistory     Current OrderHistory
     */
    public function __construct(
        OrderInterface $order,
        OrderHistoryInterface $lastOrderHistory,
        OrderHistoryInterface $orderHistory
    )
    {
        parent::__construct($order, $lastOrderHistory);

        $this->orderHistory = $orderHistory;
    }

    /**
     * Return current OrderHistory object
     *
     * @return OrderHistoryInterface current OrderHistory object
     */
    public function getOrderHistory()
    {
        return $this->orderHistory;
    }
}
