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

namespace Elcodi\CartBundle\Event;

use Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface;
use Elcodi\CartBundle\Entity\Interfaces\OrderInterface;
use Elcodi\CartBundle\Event\Abstracts\AbstractOrderStateEvent;

/**
 * Event dispatched when a new state is added into OrderHistory
 */
class OrderStateOnChangeEvent extends AbstractOrderStateEvent
{
    /**
     * @var OrderHistoryInterface
     *
     * New OrderHistory object
     */
    protected $newOrderHistory;

    /**
     * construct method
     *
     * @param OrderInterface        $order            Order
     * @param OrderHistoryInterface $lastOrderHistory Last OrderHistory
     * @param OrderHistoryInterface $newOrderHistory  New OrderHistory
     * @param string                $newState         New state to reach
     */
    public function __construct(
        OrderInterface $order,
        OrderHistoryInterface $lastOrderHistory,
        OrderHistoryInterface $newOrderHistory,
        $newState
    )
    {
        parent::__construct(
            $order,
            $lastOrderHistory,
            $newState
        );

        $this->newOrderHistory = $newOrderHistory;
    }

    /**
     * Return current OrderHistory object
     *
     * @return OrderHistoryInterface current OrderHistory object
     */
    public function getNewOrderHistory()
    {
        return $this->newOrderHistory;
    }
}
