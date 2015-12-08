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

namespace Elcodi\Component\Shipping\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Shipping\Entity\ShippingMethod;

class ShippingMethodTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ShippingMethod
     */
    protected $object;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $carrierName;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var MoneyInterface
     */
    private $price;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->id = sha1(rand());
        $this->carrierName = sha1(rand());
        $this->name = sha1(rand());
        $this->description = sha1(rand());
        $this->price = $this->getMock('Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface');

        $this->object = new ShippingMethod(
            $this->id,
            $this->carrierName,
            $this->name,
            $this->description,
            $this->price
        );
    }

    public function testGetId()
    {
        $this->assertSame($this->id, $this->object->getId());
    }

    public function testGetCarrierName()
    {
        $this->assertSame($this->carrierName, $this->object->getCarrierName());
    }

    public function testGetName()
    {
        $this->assertSame($this->name, $this->object->getName());
    }

    public function testGetDescription()
    {
        $this->assertSame($this->description, $this->object->getDescription());
    }

    public function testGetPrice()
    {
        $this->assertSame($this->price, $this->object->getPrice());
    }
}
