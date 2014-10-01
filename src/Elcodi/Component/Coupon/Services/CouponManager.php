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

namespace Elcodi\Component\Coupon\Services;

use DateTime;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Exception\CouponAppliedException;
use Elcodi\Component\Coupon\Exception\CouponBelowMinimumPurchaseException;
use Elcodi\Component\Coupon\Exception\CouponNotActiveException;
use Elcodi\Component\Coupon\Factory\CouponFactory;

/**
 * Coupon manager service
 *
 * Manages all coupon actions
 *
 * Public methods:
 *
 * * checkCoupon(CouponInterface, $price)
 * * duplicateCoupon(CouponInterface)
 */
class CouponManager
{
    /**
     * @var CouponFactory
     *
     * Coupon Factory
     */
    protected $couponFactory;

    /**
     * @var GeneratorInterface
     *
     * Coupon Code generator
     */
    protected $couponCodeGenerator;

    /**
     * Construct method
     *
     * @param CouponFactory      $couponFactory       Coupon Factory
     * @param GeneratorInterface $couponCodeGenerator Generator
     */
    public function __construct(
        CouponFactory $couponFactory,
        GeneratorInterface $couponCodeGenerator
    )
    {
        $this->couponFactory = $couponFactory;
        $this->couponCodeGenerator = $couponCodeGenerator;
    }

    /**
     * Checks whether a coupon can be applied or not.
     *
     * @param CouponInterface $coupon Coupon to work with
     * @param float           $price  Price
     *
     * @return boolean Coupon can be applied
     *
     * @throws CouponBelowMinimumPurchaseException
     * @throws CouponAppliedException
     * @throws CouponNotActiveException
     */
    protected function checkCoupon(CouponInterface $coupon, $price)
    {
        /**
         * check if coupon is enabled and not deleted
         */
        if (!$coupon->isEnabled()) {

            throw new CouponNotActiveException();
        }

        $now = new DateTime();

        /**
         * check if coupon is active
         */
        if (($coupon->getValidFrom()) > $now || ($coupon->getValidTo() < $now)) {

            throw new CouponNotActiveException();
        }

        /**
         * check if coupon still can be applied
         */
        if (($coupon->getCount() - $coupon->getUsed()) < 1) {

            throw new CouponAppliedException();
        }

        /**
         * you cannot add this coupon, too cheap
         */
        if ($coupon->getMinimumPurchase()->getAmount() > $price) {

            throw new CouponBelowMinimumPurchaseException();
        }

        return true;
    }

    /**
     * Creates a new coupon instance, given an existing Coupon as reference
     *
     * You can specify a DateTime new coupon will be valid from.
     * If not specified, current DateTime will be used
     *
     * If given coupon is valid forever, new coupon will also be
     * Otherwise, this method will add to validFrom, the same interval than given Coupon
     *
     * Also can be specified how new Coupon name must be defined.
     * If none, automatic generator will add to existing name, 10 random digits.
     *
     * Given Coupon name: FOO
     * New Coupon name: FOO_a67b6786a6
     *
     * Coupons are only generated, and are not persisted in Manager not Flushed
     *
     * @param CouponInterface $coupon   Reference coupon
     * @param DateTime        $dateFrom Date From. If null, takes actual dateTime
     *
     * @return CouponInterface Coupon generated
     */
    public function duplicateCoupon(CouponInterface $coupon, DateTime $dateFrom = null)
    {
        /**
         * Creates a valid date interval given the referent Coupon
         */
        if (!($dateFrom instanceof DateTime)) {

            $dateFrom = new DateTime();
        }

        $dateTo = null;
        if ($coupon->getValidTo() instanceof DateTime) {

            $interval = $coupon->getValidFrom()->diff($coupon->getValidTo());
            $dateTo = clone $dateFrom;
            $dateTo->add($interval);
        }

        /**
         * @var CouponInterface $couponGenerated
         */
        $couponGenerated = $this->couponFactory->create();
        $couponGenerated
            ->setCode($this->couponCodeGenerator->generate())
            ->setName($coupon->getName())
            ->setType($coupon->getType())
            ->setPrice($coupon->getPrice())
            ->setDiscount($coupon->getDiscount())
            ->setCount($coupon->getCount())
            ->setPriority($coupon->getPriority())
            ->setMinimumPurchase($coupon->getMinimumPurchase())
            ->setValidFrom($dateFrom)
            ->setValidTo($dateTo)
            ->setEnabled(true);

        return $couponGenerated;
    }
}
