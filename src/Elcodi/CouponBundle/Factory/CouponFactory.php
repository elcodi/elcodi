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
            ->setMinimumPurchaseAmount(0)
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $coupon;
    }
}
