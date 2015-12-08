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

namespace Elcodi\Component\Currency\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Currency\Entity\Currency;

class CurrencyTest extends PHPUnit_Framework_TestCase
{
    use Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var Currency
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Currency();
    }

    public function testIso()
    {
        $iso = sha1(rand());

        $setterOutput = $this->object->setIso($iso);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getIso();
        $this->assertSame($iso, $getterOutput);
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testSymbol()
    {
        $symbol = sha1(rand());

        $setterOutput = $this->object->setSymbol($symbol);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSymbol();
        $this->assertSame($symbol, $getterOutput);
    }
}
