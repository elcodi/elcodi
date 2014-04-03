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

namespace Elcodi\CouponBundle\Tests\Functional\Form\Type;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Tests CouponType class
 */
class CouponTypeTest extends WebTestCase
{

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.coupon.form_types.coupon';
    }
}
