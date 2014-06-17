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

namespace Elcodi\CartBundle\Tests\UnitTest\Factory;

use PHPUnit_Framework_TestCase;

use Elcodi\CartBundle\Factory\OrderLineFactory;
use Elcodi\CartBundle\Factory\OrderLineHistoryFactory;

/**
 * Class OrderLineFactoryTest
 */
class OrderLineFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test object creation
     *
     * @group order
     */
    public function testCreate()
    {
        $orderLineHistoryFactory = new OrderLineHistoryFactory();
        $orderLineHistoryFactory
            ->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLineHistory');

        $orderLineFactory = new OrderLineFactory();
        $orderLineFactory
            ->setOrderLineHistoryFactory($orderLineHistoryFactory)
            ->setInitialOrderHistoryState('new')
            ->setEntityNamespace('Elcodi\CartBundle\Entity\OrderLine');
        $orderLine = $orderLineFactory->create();

        $this->assertCount(
            1,
            $orderLine->getOrderLineHistories()
        );

        $this->assertInstanceOf(
            'Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface',
            $orderLine->getOrderLineHistories()->first()
        );

        $this->assertEquals(
            'new',
            $orderLine->getOrderLineHistories()->first()->getState()
        );

        $this->assertInstanceOf(
            'Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface',
            $orderLine->getLastOrderLineHistory()
        );

        $this->assertSame(
            $orderLine->getOrderLineHistories()->first(),
            $orderLine->getLastOrderLineHistory()
        );
    }
}
