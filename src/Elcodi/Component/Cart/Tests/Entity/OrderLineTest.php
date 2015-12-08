<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\Cart\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\OrderLine;
use Elcodi\Component\Core\Tests\Entity\Traits;

class OrderLineTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    const ORDER_INTERFACE = 'Elcodi\Component\Cart\Entity\Interfaces\OrderInterface';

    /**
     * @var OrderLine
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new OrderLine();
    }

    public function testOrder()
    {
        $order = $this->getMock(self::ORDER_INTERFACE);

        $setterOutput = $this->object->setOrder($order);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrder();
        $this->assertSame($order, $getterOutput);
    }
}
