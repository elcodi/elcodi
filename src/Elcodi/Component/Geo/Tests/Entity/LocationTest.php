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

namespace Elcodi\Component\Geo\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Geo\Entity\Location;

class LocationTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    /**
     * @var Location
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Location();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testCode()
    {
        $code = sha1(rand());

        $setterOutput = $this->object->setCode($code);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCode();
        $this->assertSame($code, $getterOutput);
    }

    public function testType()
    {
        $type = sha1(rand());

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testGetAllParents()
    {
        $e1 = $this->getMock(get_class($this->object));
        $e2 = $this->getMock(get_class($this->object));
        $e3 = $this->getMock(get_class($this->object));

        $parent = new Location();
        $parent->setParents(new ArrayCollection([
            $e1,
        ]));

        $this->object->setParents(new ArrayCollection([
            $e2,
            $e3,
            $parent,
        ]));

        $getterOutput = $this->object->getAllParents();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(4, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);
    }

    public function testParents()
    {
        $e1 = $this->getMock(get_class($this->object));
        $e2 = $this->getMock(get_class($this->object));

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setParents($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getParents();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);

        $adderOutput = $this->object->addParent($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getParents();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);

        $removerOutput = $this->object->removeParent($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getParents();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testChildren()
    {
        $e1 = $this->getMock(get_class($this->object));
        $e2 = $this->getMock(get_class($this->object));

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setChildren($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getChildren();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);

        $adderOutput = $this->object->addChildren($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getChildren();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf(get_class($this->object), $getterOutput);
    }

    public function testToString()
    {
        $this->assertEmpty((string) $this->object);
    }
}
