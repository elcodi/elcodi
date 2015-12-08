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

namespace Elcodi\Component\Configuration\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Configuration\Entity\Configuration;
use Elcodi\Component\Core\Tests\Entity\Traits;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    use Traits\DateTimeTrait;

    /**
     * @var Configuration
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Configuration();
    }

    public function testKey()
    {
        $key = sha1(rand());

        $setterOutput = $this->object->setKey($key);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getKey();
        $this->assertSame($key, $getterOutput);
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testNamespace()
    {
        $namespace = sha1(rand());

        $setterOutput = $this->object->setNamespace($namespace);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getNamespace();
        $this->assertSame($namespace, $getterOutput);
    }

    public function testType()
    {
        $type = sha1(rand());

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testValue()
    {
        $value = sha1(rand());

        $setterOutput = $this->object->setValue($value);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getValue();
        $this->assertSame($value, $getterOutput);
    }
}
