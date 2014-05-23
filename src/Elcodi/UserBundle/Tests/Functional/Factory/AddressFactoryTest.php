<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\UserBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class AddressFactoryTest
 */
class AddressFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.user.factory.address';
    }

    /**
     * Test customer factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            '\Elcodi\UserBundle\Entity\Interfaces\AddressInterface',
            $this->container->get('elcodi.core.user.entity.address.instance')
        );
    }
}
