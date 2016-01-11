<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Core\Tests\UnitTest\Factory\Abstracts;

use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractFactoryTest.
 */
abstract class AbstractFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Return the factory namespace.
     *
     * @return string Factory namespace
     */
    abstract public function getFactoryNamespace();

    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    abstract public function getEntityNamespace();

    /**
     * Get mock of the factory.
     */
    protected function getFactoryMock()
    {
        $factoryNamespace = $this->getFactoryNamespace();

        return $this->getMock($factoryNamespace, [
            'now',
            'getEntityNamespace',
        ], [], '', false);
    }

    /**
     * Test creation of the.
     */
    public function testCreate()
    {
        $factory = $this->getFactoryMock();
        $factory
            ->method('now')
            ->will($this->returnValue(new DateTime()));

        $factory
            ->method('getEntityNamespace')
            ->will($this->returnValue($this->getEntityNamespace()));

        $instance = $factory->create();
        $this->assertInstanceOf(
            $this->getEntityNamespace(),
            $instance
        );
    }
}
