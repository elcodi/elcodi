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

namespace Elcodi\CartBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class OrderLineHistoryFactoryTest
 */
class OrderLineHistoryFactoryTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadSchema()
    {
        return false;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.factory.order_line_history',
            'elcodi.factory.order_line_history',
        ];
    }

    /**
     * Test order_line_history factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart.entity.order_line_history.class'),
            $this->container->get('elcodi.core.cart.entity.order_line_history.instance')
        );
    }

    /**
     * Test order_line_history factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.cart.entity.order_line_history.class'),
            $this->container->get('elcodi.entity.order_line_history.instance')
        );
    }
}
