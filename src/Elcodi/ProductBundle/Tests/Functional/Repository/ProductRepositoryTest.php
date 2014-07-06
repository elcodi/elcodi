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

namespace Elcodi\ProductBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class ProductRepositoryTest
 */
class ProductRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.product.repository.product',
            'elcodi.repository.product',
        ];
    }

    /**
     * Test product repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.product.repository.product.class'),
            $this->container->get('elcodi.core.product.repository.product')
        );
    }

    /**
     * Test product repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.product.repository.product.class'),
            $this->container->get('elcodi.repository.product')
        );
    }
}
