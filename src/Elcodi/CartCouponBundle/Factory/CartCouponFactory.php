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

namespace Elcodi\CartCouponBundle\Factory;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CartCouponBundle\Entity\CartCoupon;

/**
 * Class CartCoupon
 */
class CartCouponFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return CartCoupon New CartCoupon instance
     */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
        $cartCoupon = new $classNamespace();

        return $cartCoupon;
    }
}
