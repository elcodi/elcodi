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

namespace Elcodi\Component\Cart\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface;
use Elcodi\Component\Cart\Entity\OrderLine;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class OrderLine
 */
class OrderLineFactory extends AbstractFactory
{
    /**
     * @var OrderLineHistoryFactory
     *
     * OrderLineHistory Factory
     */
    protected $orderLineHistoryFactory;

    /**
     * @var string
     *
     * Initial History state
     */
    protected $initialOrderHistoryState;

    /**
     * Set orderLineHistoryFactory
     *
     * @param OrderLineHistoryFactory $orderLineHistoryFactory OrderLineHistory Factory
     *
     * @return $this self Object
     */
    public function setOrderLineHistoryFactory(OrderLineHistoryFactory $orderLineHistoryFactory)
    {
        $this->orderLineHistoryFactory = $orderLineHistoryFactory;

        return $this;
    }

    /**
     * Set initial history state
     *
     * @param string $initialOrderHistoryState Initial order history state
     *
     * @return $this self Object
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
     * @return OrderLine New OrderLine instance
     */
    public function create()
    {
        /**
         * @var OrderLine $orderLine
         */
        $classNamespace = $this->getEntityNamespace();
        $orderLine = new $classNamespace();
        $orderLine->setOrderLineHistories(new ArrayCollection);

        $orderLine
            ->setWidth(0)
            ->setHeight(0)
            ->setWidth(0)
            ->setWeight(0);

        /**
         * @var OrderLineHistoryInterface $orderLineHistory
         */
        $orderLineHistory = $this->orderLineHistoryFactory->create();
        $orderLineHistory
            ->setOrderLine($orderLine)
            ->setState($this->initialOrderHistoryState);

        $orderLine
            ->addOrderLineHistory($orderLineHistory)
            ->setLastOrderLineHistory($orderLineHistory);

        return $orderLine;
    }
}
