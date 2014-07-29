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

namespace Elcodi\CouponBundle\Factory;

use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\CouponBundle\ElcodiCouponTypes;
use Elcodi\CouponBundle\Entity\Coupon;

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
