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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Services;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;
use Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface;
use Elcodi\Component\Cart\EventDispatcher\OrderLineStateEventDispatcher;
use Elcodi\Component\Cart\Factory\OrderLineFactory;
use Elcodi\Component\Cart\Factory\OrderLineHistoryFactory;
use Elcodi\Component\Cart\Services\OrderLineManager;
use Elcodi\Component\Cart\Services\OrderManager;
use Elcodi\Component\Cart\Services\OrderStateManager;

/**
 * Tests OrderManager class
 */
class OrderManagerTest extends WebTestCase
{
    /**
     * @var OrderManager
     *
     * OrderManager
     */
    protected $orderManager;

    /**
     * @var OrderLineStateEventDispatcher
     *
     * OrderLine State Event dispatcher
     */
    protected $orderLineStateEventDispatcher;

    /**
     * @var OrderLineManager
     *
     * OrderLineManager
     */
    protected $orderLineManager;

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.service.order_manager',
            'elcodi.order_manager',
        ];
    }

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();

        /**
         * @var OrderLineStateEventDispatcher $orderLineStateEventDispatcher
         * @var OrderLineHistoryFactory       $orderLineHistoryFactory
         * @var OrderLineFactory              $orderLineFactory
         */
        $orderLineStateEventDispatcher = $this
            ->get('elcodi.order_line_state_event_dispatcher');

        $orderLineHistoryFactory = $this
            ->get('elcodi.factory.order_line_history');

        $orderLineFactory = $this
            ->get('elcodi.factory.order_line');

        $orderLineManager = new OrderLineManager(
            $orderLineStateEventDispatcher,
            $orderLineHistoryFactory,
            $orderLineFactory,
            new OrderStateManager([
                'A' => ['B'],
                'B' => ['C', 'E'],
                'C' => ['B', 'D'],
                'D' => ['E'],
                'E' => [],
            ])
        );

        $this->orderManager = new OrderManager(
            $orderLineManager,
            new OrderStateManager([
                'A' => ['B'],
                'B' => ['C', 'E'],
                'C' => ['B', 'D'],
                'D' => ['E'],
                'E' => [],
            ])
        );

        $this->orderLineStateEventDispatcher = $orderLineStateEventDispatcher;
        $this->orderLineManager = $orderLineManager;
        $this->orderLineManager = $orderLineManager;
    }

    /**
     * Test right state movements
     *
     * @dataProvider dataCheckOrderCanChangeToState
     * @group        order
     */
    public function testCheckOrderCanChangeToState(
        array $lastOrderLineStates,
        $lastOrderState,
        $newOrderState,
        $canChange
    )
    {
        $orderLines = new ArrayCollection();
        $orderLineFactory = $this
            ->get('elcodi.factory.order_line');

        foreach ($lastOrderLineStates as $lastOrderLineState) {

            /**
             * @var OrderLineInterface $orderLine
             */
            $orderLine = $orderLineFactory->create();
            $orderLine
                ->getLastOrderLineHistory()
                ->setState($lastOrderLineState);
            $orderLine
                ->addOrderLineHistory($orderLine
                    ->getLastOrderLineHistory()
                );

            $orderLines->add($orderLine);
        }

        /**
         * @var OrderInterface $order
         */
        $order = $this
            ->get('elcodi.factory.order')
            ->create()
            ->setOrderLines($orderLines);

        $order
            ->getLastOrderHistory()
            ->setState($lastOrderState);

        $this->assertEquals(
            $this
                ->orderManager
                ->checkOrderCanChangeToState(
                    $order,
                    $newOrderState
                ),
            $canChange
        );
    }

    /**
     * Data for testCheckOrderCanChangeToState
     */
    public function dataCheckOrderCanChangeToState()
    {
        return [
            [['A', 'A'], 'A', 'B', true],
            [['A', 'B'], 'A', 'B', true],
            [['B', 'B'], 'B', 'B', true],
            [['B', 'B', 'A'], 'B', 'B', true],
            [['B', 'A', 'A'], 'B', 'B', true],
            [[], 'B', 'B', true],
            [['B', 'B'], 'A', 'A', false],
            [['B', 'B'], null, 'A', false],
            [['B', 'B'], true, 'A', false],
            [['B', 'B'], false, 'A', false],
            [['B', 'B'], '', 'A', false],
            [['', 'B'], 'A', 'A', false],
            [[true, 'B'], 'A', 'A', false],
            [[false, 'B'], 'A', 'A', false],
            [[null, 'B'], 'A', 'A', false],
            [[[], 'B'], 'A', 'A', false],
            [[['A'], 'B'], 'A', 'A', false],
        ];
    }
}
