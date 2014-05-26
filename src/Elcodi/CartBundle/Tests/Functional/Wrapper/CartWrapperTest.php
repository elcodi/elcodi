<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */

namespace Elcodi\CartBundle\Tests\Functional\Wrapper;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class CartWrapperTest
 */
class CartWrapperTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.wrapper.cart_wrapper',
            'elcodi.cart_wrapper',
        ];
    }
}
