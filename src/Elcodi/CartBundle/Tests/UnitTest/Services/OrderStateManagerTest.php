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

namespace Elcodi\CartBundle\Tests\UnitTest\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\CartBundle\Services\OrderStateManager;

/**
 * Class OrderStateManagerTest
 */
class OrderStateManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test valid state changes.
     *
     * @dataProvider dataPassCheckChangeToState
     * @group orderstate
     */
    public function testPassCheckChangeToState($fromState, $toState, $result)
    {
        $orderStateManager = new OrderStateManager([
            'A' => ['B'],
            'B' => ['C', 'E'],
            'C' => ['B', 'D'],
            'D' => ['E'],
            'E' => [],
        ]);

        $this->assertEquals(
            $result,
            $orderStateManager->isOrderStateChangePermitted($fromState, $toState)
        );
    }

    /**
     * Data for testPassCheckChangeToState
     */
    public function dataPassCheckChangeToState()
    {
        return [
            ['A', 'B', true],
            ['C', 'B', true],
            ['B', 'E', true],
            ['A', 'C', false],
            ['E', 'D', false],
            ['A', '', false],
            ['A', true, false],
            ['A', false, false],
            ['A', 'true', false],
            ['A', [], false],
            ['A', null, false],
            [false, 'B', false],
            [true, 'B', false],
            [null, 'B', false],
            ['', 'B', false],
            ['true', 'A', false],
        ];
    }
}
