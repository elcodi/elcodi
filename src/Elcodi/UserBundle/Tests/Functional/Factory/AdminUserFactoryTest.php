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
 * Class AdminUserFactoryTest
 */
class AdminUserFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.user.factory.admin_user',
            'elcodi.factory.admin_user',
        ];
    }

    /**
     * Test admin user factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.entity.admin_user.class'),
            $this->container->get('elcodi.core.user.entity.admin_user.instance')
        );
    }

    /**
     * Test admin user factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.entity.admin_user.class'),
            $this->container->get('elcodi.entity.admin_user.instance')
        );
    }
}
