<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ManufacturerFactoryTest
 */
class ManufacturerFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.product.factory.manufacturer',
            'elcodi.factory.manufacturer',
        ];
    }

    /**
     * Test manufacturer factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.product.entity.manufacturer.class'),
            $this->container->get('elcodi.core.product.entity.manufacturer.instance')
        );
    }

    /**
     * Test manufacturer factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.product.entity.manufacturer.class'),
            $this->container->get('elcodi.entity.manufacturer.instance')
        );
    }
}
