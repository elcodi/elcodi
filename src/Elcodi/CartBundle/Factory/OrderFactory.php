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

namespace Elcodi\CartBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CartBundle\Entity\Order;

/**
 * Class Order
 */
class OrderFactory extends AbstractFactory
{
    /**
     * @var OrderHistoryFactory
     *
     * OrderHistory Factory
     */
    protected $orderHistoryFactory;

    /**
     * @var string
     *
     * Initial History state
     */
    protected $initialOrderHistoryState;

    /**
     * Set orderHistoryFactory
     *
     * @param OrderHistoryFactory $orderHistoryFactory OrderHistory Factory
     *
     * @return OrderFactory self Object
     */
    public function setOrderHistoryFactory(OrderHistoryFactory $orderHistoryFactory)
    {
        $this->orderHistoryFactory = $orderHistoryFactory;

        return $this;
    }

    /**
     * Set initial history state
     *
     * @param string $initialOrderHistoryState Initial order history state
     *
     * @return OrderFactory self Object
     */
    public function setInitialOrderHistoryState($initialOrderHistoryState)
    {
        $this->initialOrderHistoryState = $initialOrderHistoryState;

        return $this;
    }

    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Order New Order instance
     */
    public function create()
    {
        /**
         * @var Order $order
         */
        $classNamespace = $this->getEntityNamespace();
        $order = new $classNamespace();
        $order
            ->setQuantity(0)
            ->setOrderLines(new ArrayCollection)
            ->setOrderHistories(new ArrayCollection)
            ->setCreatedAt(new DateTime);

        $orderHistory = $this->orderHistoryFactory->create();
        $orderHistory
            ->setOrder($order)
            ->setState($this->initialOrderHistoryState);
        $order
            ->addOrderHistory($orderHistory)
            ->setLastOrderHistory($orderHistory);

        return $order;
    }
}
