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

namespace Elcodi\VariantBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class VariantFactoryTest
 */
class VariantFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.variant.factory.variant',
            'elcodi.factory.variant',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiAttributeBundle',
            'ElcodiCurrencyBundle',
            'ElcodiProductBundle',
            'ElcodiVariantBundle'
        );
    }

    /**
     * Test menu factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.variant.entity.variant.class'),
            $this->container->get('elcodi.core.variant.entity.variant.instance')
        );
    }

    /**
     * Test variant factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.variant.entity.variant.class'),
            $this->container->get('elcodi.entity.variant.instance')
        );
    }

    public function testProductInstance()
    {
        $product = $this->container->get('elcodi.core.variant.entity.product.instance');
    }

}
