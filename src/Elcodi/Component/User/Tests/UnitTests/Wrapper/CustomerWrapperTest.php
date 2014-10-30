<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Component\User\Tests\UnitTests\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Factory\CustomerFactory;
use Elcodi\Component\User\Wrapper\CustomerWrapper;

/**
 * Class CustomerWrapperTest
 *
 * @author Berny Cantos <be@rny.cc>
 */
class CustomerWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testLoadCustomerFromToken()
    {
        $customer = $this->mockCustomer();
        $factory = $this->mockCustomerFactory();
        $token = $this->mockSecurityToken();
        $context = $this->mockSecurityContext();

        $context
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

        $wrapper = new CustomerWrapper($factory, $context);
        $actual = $wrapper->loadCustomer();

        $this->assertSame($customer, $actual);
    }

    /**
     *
     */
    public function testCreateCustomerWhenTokenIsEmpty()
    {
        $customer = $this->mockCustomer();
        $factory = $this->mockCustomerFactory();
        $token = $this->mockSecurityToken();
        $context = $this->mockSecurityContext();

        $context
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

        $wrapper = new CustomerWrapper($factory, $context);
        $actual = $wrapper->loadCustomer();

        $this->assertSame($customer, $actual);
    }

    /**
     *
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
        $actual = $wrapper->loadCustomer();

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
     * @return SecurityContextInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSecurityContext()
    {
        return $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
    }

    /**
     * @return TokenInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockSecurityToken()
    {
        return $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
    }
}
