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

namespace Elcodi\Component\Coupon\Factory;

use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Coupon\Entity\Coupon;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Currency\Factory\Abstracts\AbstractPurchasableFactory;

/**
 * Class CouponFactory.
 */
class CouponFactory extends AbstractPurchasableFactory
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
        $now = $this->now();
        $zeroPrice = $this->createZeroAmountMoney();

        /**
         * @var CouponInterface $coupon
         */
        $classNamespace = $this->getEntityNamespace();
        $coupon = new $classNamespace();
        $coupon
            ->setType(ElcodiCouponTypes::TYPE_AMOUNT)
            ->setPrice($zeroPrice)
            ->setAbsolutePrice($zeroPrice)
            ->setMinimumPurchase($zeroPrice)
            ->setEnforcement(ElcodiCouponTypes::ENFORCEMENT_MANUAL)
            ->setUsed(0)
            ->setCount(0)
            ->setPriority(0)
            ->setStackable(false)
            ->setEnabled(false)
            ->setCreatedAt($now)
            ->setValidFrom($now);

        return $coupon;
    }
}
