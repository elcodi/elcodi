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

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Geo\Entity\Address;

class AddressTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait,
        Traits\DateTimeTrait,
        Traits\EnabledTrait;

    /**
     * @var Address
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Address();
    }

    public function testAddress()
    {
        $address = sha1(rand());

        $setterOutput = $this->object->setAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testAddressMore()
    {
        $addressMore = sha1(rand());

        $setterOutput = $this->object->setAddressMore($addressMore);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAddressMore();
        $this->assertSame($addressMore, $getterOutput);
    }

    public function testComments()
    {
        $comments = sha1(rand());

        $setterOutput = $this->object->setComments($comments);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getComments();
        $this->assertSame($comments, $getterOutput);
    }

    public function testMobile()
    {
        $mobile = sha1(rand());

        $setterOutput = $this->object->setMobile($mobile);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getMobile();
        $this->assertSame($mobile, $getterOutput);
    }

    public function testName()
    {
        $name = sha1(rand());

        $setterOutput = $this->object->setName($name);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getName();
        $this->assertSame($name, $getterOutput);
    }

    public function testPhone()
    {
        $phone = sha1(rand());

        $setterOutput = $this->object->setPhone($phone);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPhone();
        $this->assertSame($phone, $getterOutput);
    }

    public function testRecipientName()
    {
        $recipientName = sha1(rand());

        $setterOutput = $this->object->setRecipientName($recipientName);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getRecipientName();
        $this->assertSame($recipientName, $getterOutput);
    }

    public function testRecipientSurname()
    {
        $recipientSurname = sha1(rand());

        $setterOutput = $this->object->setRecipientSurname($recipientSurname);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getRecipientSurname();
        $this->assertSame($recipientSurname, $getterOutput);
    }

    public function testCity()
    {
        $city = sha1(rand());

        $setterOutput = $this->object->setCity($city);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCity();
        $this->assertSame($city, $getterOutput);
    }

    public function testPostalcode()
    {
        $postalCode = sha1(rand());

        $setterOutput = $this->object->setPostalcode($postalCode);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPostalcode();
        $this->assertSame($postalCode, $getterOutput);
    }
}
