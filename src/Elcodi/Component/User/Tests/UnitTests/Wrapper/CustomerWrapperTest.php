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

namespace Elcodi\Component\User\Tests\UnitTests\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Factory\CustomerFactory;
use Elcodi\Component\User\Wrapper\CustomerWrapper;

/**
 * Class CustomerWrapperTest.
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CustomerWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Given a security token pointing to a valid customer C
     * When  I ask the wrapper to load a customer
     * Then  it returns C.
     */
    public function testLoadCustomerFromToken()
    {
        $customer = $this->mockCustomer();
        $factory = $this->mockCustomerFactory();
        $token = $this->mockSecurityToken();
        $tokenStorage = $this->mockTokenStorage();

        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $token
            ->expects($this->atLeastOnce())
            ->method('getUser')
            ->willReturn($customer);

        $factory
            ->expects($this->never())
            ->method('create');

        $wrapper = new CustomerWrapper($factory, $tokenStorage);
        $actual = $wrapper->get();

        $this->assertSame($customer, $actual);
    }

    /**
     * Given a security token with no user
     *   and a customer factory F
     * When  I ask the wrapper to load a customer
     * Then  it calls F to create a new customer C
     *  and  it returns C.
     */
    public function testCreateCustomerWhenTokenIsEmpty()
    {
        $customer = $this->mockCustomer();
        $factory = $this->mockCustomerFactory();
        $token = $this->mockSecurityToken();
        $tokenStorage = $this->mockTokenStorage();

        $tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($token);

        $token
            ->expects($this->atLeastOnce())
            ->method('getUser')
            ->willReturn(null);

        $factory
            ->expects($this->once())
            ->method('create')
            ->willReturn($customer);

        $wrapper = new CustomerWrapper($factory, $tokenStorage);
        $actual = $wrapper->get();

        $this->assertSame($customer, $actual);
    }

    /**
     * Given there are no security token
     *   and a customer factory F
     * When  I ask the wrapper to load a customer
     * Then  it calls F to create a new customer C
     *  and  it returns C.
     */
    public function testCreateCustomerWhenNoSecurityContext()
    {
        $customer = $this->mockCustomer();
        $factory = $this->mockCustomerFactory();

        $factory
            ->expects($this->once())
            ->method('create')
            ->willReturn($customer);

        $wrapper = new CustomerWrapper($factory, null);
        $actual = $wrapper->get();

        $this->assertSame($customer, $actual);
    }

    /**
     * @return CustomerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockCustomer()
    {
        return $this->getMock('Elcodi\Component\User\Entity\Interfaces\CustomerInterface');
    }

    /**
     * @return CustomerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockCustomerFactory()
    {
        return $this->getMock('Elcodi\Component\User\Factory\CustomerFactory');
    }

    /**
     * @return TokenStorageInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockTokenStorage()
    {
        return $this->getMock('Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface');
    }

    /**
     * @return TokenInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSecurityToken()
    {
        return $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
    }
}
