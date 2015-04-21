<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Cart\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Order;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;
use Elcodi\Component\StateTransitionMachine\Machine\MachineManager;

/**
 * Class Order
 */
class OrderFactory extends AbstractFactory
{
    /**
     * @var MachineManager
     *
     * Machine Manager for Payment
     */
    protected $paymentMachineManager;

    /**
     * @var MachineManager
     *
     * Machine Manager for Shipping
     */
    protected $shippingMachineManager;

    /**
     * Construct method
     *
     * @param MachineManager $paymentMachineManager  Machine Manager for Payment
     * @param MachineManager $shippingMachineManager Machine Manager for Shipping
     */
    public function __construct(
        MachineManager $paymentMachineManager,
        MachineManager $shippingMachineManager
    ) {
        $this->paymentMachineManager = $paymentMachineManager;
        $this->shippingMachineManager = $shippingMachineManager;
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
            ->setCreatedAt($this->now());

        $paymentStateLineStack = $this
            ->paymentMachineManager
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Order not paid'
            );

        $order->setPaymentStateLineStack($paymentStateLineStack);

        $shippingStateLineStack = $this
            ->shippingMachineManager
            ->initialize(
                $order,
                StateLineStack::create(
                    new ArrayCollection(),
                    null
                ),
                'Order not shipped'
            );

        $order->setShippingStateLineStack($shippingStateLineStack);

        return $order;
    }
}
