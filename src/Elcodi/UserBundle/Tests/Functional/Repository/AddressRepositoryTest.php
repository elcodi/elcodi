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

namespace Elcodi\UserBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class AddressRepositoryTest
 */
class AddressRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.user.repository.address',
            'elcodi.repository.address',
        ];
    }

    /**
     * Test address repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.repository.address.class'),
            $this->container->get('elcodi.core.user.repository.address')
        );
    }

    /**
     * Test address repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.user.repository.address.class'),
            $this->container->get('elcodi.repository.address')
        );
    }
}
