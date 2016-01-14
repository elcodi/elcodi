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

namespace Elcodi\Component\Geo\Tests\UnitTest\Adapter;

use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Geo\Entity\Address;
use Elcodi\Component\Geo\EventDispatcher\AddressEventDispatcher;
use Elcodi\Component\Geo\Services\AddressManager;

/**
 * Class AddressManagerTest.
 */
class AddressManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var AddressManager
     *
     * An address manager
     */
    protected $addressManager;

    /**
     * @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     *
     * An address object manager
     */
    protected $addressObjectManagerMock;

    /**
     * @var AddressEventDispatcher|\PHPUnit_Framework_MockObject_MockObject
     *
     * An address event dispatcher
     */
    protected $addressEventDispatcher;

    /**
     * Set ups the test to be executed.
     */
    public function setUp()
    {
        $this->addressObjectManagerMock = $this->getMockBuilder(
            'Doctrine\Common\Persistence\ObjectManager'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressEventDispatcher = $this->getMockBuilder(
            'Elcodi\Component\Geo\EventDispatcher\AddressEventDispatcher'
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressManager = new AddressManager(
            $this->addressObjectManagerMock,
            $this->addressEventDispatcher
        );
    }

    /**
     * Tests the method when the address being saved is new.
     */
    public function testSavingNewAddress()
    {
        $originalAddress = $this->getAddress(
            null,
            'New address'
        );

        $this
            ->addressObjectManagerMock
            ->expects($this->never())
            ->method('persist');

        $this
            ->addressObjectManagerMock
            ->expects($this->once())
            ->method('flush')
            ->with($originalAddress);

        $savedAddress = $this
            ->addressManager
            ->saveAddress($originalAddress);

        $this
            ->addressEventDispatcher
            ->expects($this->never())
            ->method('dispatchAddressOnCloneEvent');

        $this->assertSame(
            $savedAddress,
            $originalAddress,
            'The saved address should be the one received'
        );
    }

    /**
     * Tests the method when the address being saved is already persisted.
     */
    public function testSavingAlreadyPersistedAddress()
    {
        $originalAddress = $this->getAddress(
            '42',
            'New address'
        );

        $clonedAddress = $this->getAddress(
            null,
            'New address'
        );

        $this
            ->addressObjectManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($clonedAddress);

        $this
            ->addressObjectManagerMock
            ->expects($this->once())
            ->method('flush')
            ->with($clonedAddress);

        $this
            ->addressEventDispatcher
            ->expects($this->once())
            ->method('dispatchAddressOnCloneEvent');

        $savedAddress = $this
            ->addressManager
            ->saveAddress($originalAddress);

        $this->assertEquals(
            $savedAddress,
            $clonedAddress,
            'The saved address should be a new one'
        );
    }

    /**
     * Gets a new address class, we don't use a mock because with the clone
     * behaviour we lost control of the mock and we can't define the cloned
     * class.
     *
     * @param string|null $id   The address id
     * @param string      $name The address name
     *
     * @return Address
     */
    protected function getAddress(
        $id,
        $name
    ) {
        $address = new Address();
        $address->setId($id);
        $address->setName($name);

        return $address;
    }
}
