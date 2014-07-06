<?php

/**
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

namespace Elcodi\UserBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class CustomerFactoryTest
 */
class CustomerFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.user.factory.customer',
            'elcodi.factory.customer',
        ];
    }

    /**
     * Test customer factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.entity.customer.class'),
            $this->container->get('elcodi.core.user.entity.customer.instance')
        );
    }

    /**
     * Test customer factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.entity.customer.class'),
            $this->container->get('elcodi.entity.customer.instance')
        );
    }
}
