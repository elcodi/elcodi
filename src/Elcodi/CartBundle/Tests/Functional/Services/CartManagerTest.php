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

namespace Elcodi\CartBundle\Tests\Functional\Services;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Tests CartManager class
 */
class CartManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.cart.services.cart_manager';
    }

    /**
     * Returns if service must be retrieved from container
     *
     * @return boolean
     */
    protected function mustTestGetService()
    {
        return false;
    }
}
