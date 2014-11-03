<?php

/*
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

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Interfaces\OrderStateLineInterface;
use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class Order
 */
class OrderFactory extends AbstractFactory
{
    /**
     * @var MachineManager
     *
     * Machine Manager
     */
    protected $machineManager;

    /**
     * Construct method
     *
     * @param MachineManager $machineManager Machine Manager
     */
    public function __construct(MachineManager $machineManager)
    {
        $this->machineManager = $machineManager;
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
            ->setWidth(0)
            ->setHeight(0)
            ->setWidth(0)
            ->setWeight(0)
            ->setOrderLines(new ArrayCollection())
            ->setStateLines(new ArrayCollection())
            ->setCreatedAt(new DateTime());

        /**
         * @var OrderStateLineInterface $stateLine
         */
        $stateLine = $this
            ->machineManager
            ->initialize($order, '');

        $stateLine->setOrder($order);

        return $order;
    }
}
