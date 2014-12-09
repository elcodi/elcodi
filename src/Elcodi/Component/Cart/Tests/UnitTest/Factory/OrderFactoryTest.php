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

namespace Elcodi\Component\Cart\Tests\UnitTest\Factory;

use Elcodi\Component\Cart\Factory\OrderFactory;
use Elcodi\Component\StateTransitionMachine\Tests\UnitTest\Fixtures\AbstractStateTransitionTest;

/**
 * Class OrderFactoryTest
 */
class OrderFactoryTest extends AbstractStateTransitionTest
{
    /**
     * Test object creation
     *
     * @group order
     */
    public function testCreate()
    {
        $machineManager = $this->getMachineManager(
            1,
            'Elcodi\Component\Cart\Entity\OrderStateLine'
        );

        $factory = new OrderFactory($machineManager);
        $factory->setEntityNamespace('\Elcodi\Component\Cart\Entity\Order');

        $order = $factory->create();
        $this->assertEquals('unpaid', $order->getLastStateLine()->getName());
        $this->assertEquals('unpaid', $order->getStateLines()->last()->getName());
    }
}
