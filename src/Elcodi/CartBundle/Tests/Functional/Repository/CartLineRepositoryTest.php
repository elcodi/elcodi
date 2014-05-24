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

namespace Elcodi\CartBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class CartLineRepositoryTest
 */
class CartLineRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.repository.cart_line',
            'elcodi.repository.cart_line',
        ];
    }

    /**
     * Test cart_line repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart.repository.cart_line.class'),
            $this->container->get('elcodi.core.cart.repository.cart_line')
        );
    }

    /**
     * Test cart_line repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart.repository.cart_line.class'),
            $this->container->get('elcodi.repository.cart_line')
        );
    }
}
