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

namespace Elcodi\Component\User\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\User\Entity\Customer;

class CustomerTest extends Abstracts\AbstractUserTest
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Customer();
    }

    public function testGetRoles()
    {
        parent::testGetRoles();

        $roles = $this->object->getRoles();

        $contained = false;
        foreach ($roles as $role) {
            $contained = $contained || ('ROLE_CUSTOMER' === $role->getRole());
        }

        $this->assertTrue($contained, 'No ROLE_CUSTOMER defined.');
    }

    public function testPhone()
    {
        $phone = sha1(rand());

        $setterOutput = $this->object->setPhone($phone);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPhone();
        $this->assertSame($phone, $getterOutput);
    }

    public function testIdentityDocument()
    {
        $identityDocument = sha1(rand());

        $setterOutput = $this->object->setIdentityDocument($identityDocument);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getIdentityDocument();
        $this->assertSame($identityDocument, $getterOutput);
    }

    public function testGuest()
    {
        $guest = (bool) rand(0, 1);

        $setterOutput = $this->object->setGuest($guest);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->isGuest();
        $this->assertSame($guest, $getterOutput);
    }

    public function testNewsletter()
    {
        $newsletter = (bool) rand(0, 1);

        $setterOutput = $this->object->setNewsletter($newsletter);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getNewsletter();
        $this->assertSame($newsletter, $getterOutput);
    }

    public function testOrders()
    {
        $e1 = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface');
        $e2 = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setOrders($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrders();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface', $getterOutput);

        $adderOutput = $this->object->addOrder($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getOrders();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface', $getterOutput);

        $removerOutput = $this->object->removeOrder($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getOrders();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\OrderInterface', $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testCarts()
    {
        $e1 = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $e2 = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setCarts($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCarts();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\CartInterface', $getterOutput);

        $adderOutput = $this->object->addCart($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getCarts();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\CartInterface', $getterOutput);

        $removerOutput = $this->object->removeCart($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getCarts();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Cart\Entity\Interfaces\CartInterface', $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testAddresses()
    {
        $e1 = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');
        $e2 = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');

        $collection = new ArrayCollection([
            $e1,
        ]);

        $setterOutput = $this->object->setAddresses($collection);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAddresses();
        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $getterOutput);
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface', $getterOutput);

        $adderOutput = $this->object->addAddress($e2);
        $this->assertInstanceOf(get_class($this->object), $adderOutput);

        $getterOutput = $this->object->getAddresses();
        $this->assertCount(2, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface', $getterOutput);

        $removerOutput = $this->object->removeAddress($e2);
        $this->assertInstanceOf(get_class($this->object), $removerOutput);

        $getterOutput = $this->object->getAddresses();
        $this->assertCount(1, $getterOutput);
        $this->assertContainsOnlyInstancesOf('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface', $getterOutput);

        $this->assertSame($e1, $getterOutput[0]);
    }

    public function testDeliveryAddress()
    {
        $address = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');

        $setterOutput = $this->object->setDeliveryAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getDeliveryAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testInvoiceAddress()
    {
        $address = $this->getMock('Elcodi\Component\Geo\Entity\Interfaces\AddressInterface');

        $setterOutput = $this->object->setInvoiceAddress($address);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getInvoiceAddress();
        $this->assertSame($address, $getterOutput);
    }

    public function testLanguage()
    {
        $language = $this->getMock('Elcodi\Component\Language\Entity\Interfaces\LanguageInterface');

        $setterOutput = $this->object->setLanguage($language);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLanguage();
        $this->assertSame($language, $getterOutput);
    }
}
