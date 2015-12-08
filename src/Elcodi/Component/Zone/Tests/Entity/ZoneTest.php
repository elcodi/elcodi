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

namespace Elcodi\Component\Zone\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Zone\Entity\Zone;

class ZoneTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var Zone
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Zone();
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    /**
     * Testing expected behaviour.
     */
    public function testLocations()
    {
        $locations = range('a', 'z');

        $setterOutput = $this->object->setLocations($locations);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLocations();
        $this->assertSame($locations, $getterOutput);

        $newLocation = 'foo';

        // add a new location
        $setterOutput = $this->object->addLocation($newLocation);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLocations();
        $this->assertContains($newLocation, $getterOutput);

        // remove new location
        $setterOutput = $this->object->removeLocation($newLocation);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLocations();
        $this->assertNotContains($newLocation, $getterOutput);
    }

    /**
     * Test duplicated location.
     */
    public function testDuplicatedLocation()
    {
        $locations = range('a', 'z');

        $this->object->setLocations($locations);

        $this->object->addLocation('a');

        $getterOutput = $this->object->getLocations();
        $this->assertSame($locations, $getterOutput);
    }

    /**
     * Test remove not existing location.
     */
    public function testRemoveNotExistingLocation()
    {
        $locations = range('a', 'z');

        $this->object->setLocations($locations);

        $this->object->removeLocation('foo');

        $getterOutput = $this->object->getLocations();
        $this->assertSame($locations, $getterOutput);
    }
}
