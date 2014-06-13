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

namespace Elcodi\CartBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\CartBundle\Entity\OrderLine;
use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;

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
     * @return OrderLineFactory self Object
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
     * @return OrderLineFactory self Object
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
