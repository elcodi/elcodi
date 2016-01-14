<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\CartCoupon\Factory;

use Elcodi\Component\CartCoupon\Entity\OrderCoupon;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Class OrderCoupon.
 */
class OrderCouponFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance for related entity
     *
     * @return OrderCoupon New OrderCoupon instance
     */
    public function create()
    {
        $classNamespace = $this->getEntityNamespace();
        $orderCoupon = new $classNamespace();

        return $orderCoupon;
    }
}
