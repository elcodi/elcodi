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

namespace Elcodi\Component\StateTransitionMachine\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface;
use Elcodi\Component\StateTransitionMachine\Entity\StateLineStack;

class StateLineStackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StateLineStack
     */
    protected $object;

    /**
     * @var Collection
     */
    private $stateLines;

    /**
     * @var null|StateLineInterface
     */
    private $lastStateLine;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->stateLines = $this->getMock('Doctrine\Common\Collections\Collection');

        $this->object = new StateLineStack($this->stateLines);
    }

    public function testStateLines()
    {
        $this->assertInstanceOf(
            'Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface',
            $this->object->getLastStateLine()
        );
        $this->assertInstanceOf(get_class($this->stateLines), $this->object->getStateLines());

        $e1 = $this->getMock('Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface');
        $e2 = $this->getMock('Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = StateLineStack::create($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getStateLines();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface',
            $getterOutput
        );

        $adderOutput = $this->object->addStateLine($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getStateLines();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface',
            $getterOutput
        );

        $removerOutput = $this->object->removeStateLine($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getStateLines();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(
            'Elcodi\Component\StateTransitionMachine\Entity\Interfaces\StateLineInterface',
            $getterOutput
        );

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testCreate()
    {
        $stateLineStack = StateLineStack::create($this->stateLines);

        $this->assertInstanceOf(get_class($stateLineStack), $stateLineStack);
    }
}
