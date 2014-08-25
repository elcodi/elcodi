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

namespace Elcodi\Component\Coupon\Factory;

use DateTime;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Coupon;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Class CouponFactory
 */
class CouponFactory extends AbstractFactory
{
    /**
     * Creates an instance of a simple coupon.
     *
     * This method must return always an empty instance for related entity
     *
     * @return Coupon Empty entity
     */
    public function create()
    {
        /**
         * @var CouponInterface $coupon
         */
        $classNamespace = $this->getEntityNamespace();
        $coupon = new $classNamespace();
        $coupon
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setEnforcement(ElcodiCouponTypes::ENFORCEMENT_MANUAL)
            ->setUsed(0)
            ->setPriority(0)
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $coupon;
    }
}
