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

namespace Elcodi\CouponBundle\Generator;

use Elcodi\CoreBundle\Generator\Interfaces\GeneratorInterface;

/**
 * Class CouponCodeGenerator
 */
class CouponCodeGenerator implements GeneratorInterface
{
    /**
     * Generates a hash (10 characters length) for new Coupon.
     *
     * @return string Hash generated
     */
    public function generate()
    {
        return substr(hash("sha1", uniqid(rand(), true)), -10);
    }
}
