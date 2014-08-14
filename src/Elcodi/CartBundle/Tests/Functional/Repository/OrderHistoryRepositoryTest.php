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

namespace Elcodi\CartBundle\Tests\Functional\Repository;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class OrderHistoryRepositoryTest
 */
class OrderHistoryRepositoryTest extends WebTestCase
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
            'elcodi.core.cart.repository.order_history',
            'elcodi.repository.order_history',
        ];
    }

    /**
     * Test order_history repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.cart.repository.order_history.class'),
            $this->get('elcodi.core.cart.repository.order_history')
        );
    }

    /**
     * Test order_history repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.cart.repository.order_history.class'),
            $this->get('elcodi.repository.order_history')
        );
    }
}
