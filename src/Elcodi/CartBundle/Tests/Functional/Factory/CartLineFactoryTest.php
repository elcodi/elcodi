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

namespace Elcodi\CartBundle\Tests\Functional\Factory;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CartLineFactoryTest
 */
class CartLineFactoryTest extends WebTestCase
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
            'elcodi.core.cart.factory.cart_line',
            'elcodi.factory.cart_line',
        ];
    }

    /**
     * Test cart_line factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.cart.entity.cart_line.class'),
            $this->get('elcodi.core.cart.entity.cart_line.instance')
        );
    }

    /**
     * Test cart_line factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.cart.entity.cart_line.class'),
            $this->get('elcodi.entity.cart_line.instance')
        );
    }
}
