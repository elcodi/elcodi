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

namespace Elcodi\GeoBundle\Tests\Functional\Factory;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

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
        return [
            'elcodi.core.geo.factory.address',
            'elcodi.factory.address',
        ];
    }

    /**
     * Test address factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.geo.entity.address.class'),
            $this->get('elcodi.core.geo.entity.address.instance')
        );
    }

    /**
     * Test address factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.geo.entity.address.class'),
            $this->get('elcodi.entity.address.instance')
        );
    }
}
