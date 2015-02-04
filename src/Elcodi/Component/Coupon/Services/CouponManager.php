<?php

/*
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
use Elcodi\Component\Coupon\Exception\Abstracts\AbstractCouponException;
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
    ) {
        $this->couponFactory = $couponFactory;
        $this->couponCodeGenerator = $couponCodeGenerator;
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
     * Coupons are only generated, and are not persisted in Manager nor Flushed
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
        if (null === $dateFrom) {
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
            ->setRule($coupon->getRule())
            ->setEnabled(true);

        return $couponGenerated;
    }

    /**
     * Checks whether a coupon can be applied or not.
     *
     * @param CouponInterface $coupon Coupon to work with
     * @param float           $price  Price
     *
     * @return boolean Coupon can be applied
     *
     * @throws AbstractCouponException
     */
    protected function checkCoupon(CouponInterface $coupon, $price)
    {
        if (!$this->IsActive($coupon)) {
            throw new CouponNotActiveException();
        }

        if (!$this->canBeUsed($coupon)) {
            throw new CouponAppliedException();
        }

        if (!$this->isApplicable($coupon)) {
            throw new CouponBelowMinimumPurchaseException();
        }

        /**
         * check if coupon still can be applied
         */
        $count = $coupon->getCount();
        if (null !== $count && $count > $coupon->getUsed()) {
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
     * Check if a coupon is currently active
     *
     * @param CouponInterface $coupon Coupon to check activeness
     * @param DateTime        $now
     *
     * @return bool
     */
    protected function isActive(CouponInterface $coupon, \DateTime $now = null)
    {
        if (!$coupon->isEnabled()) {
            return false;
        }

        $now = $now ?: new DateTime();
        if ($coupon->getValidFrom() > $now) {
            return false;
        }

        $validTo = $coupon->getValidTo();
        if ($validTo && $now > $validTo) {
            return false;
        }

        return true;
    }

    /**
     * Check if a coupon can be currently used
     *
     * @param CouponInterface $coupon
     *
     * @return bool
     */
    protected function canBeUsed(CouponInterface $coupon)
    {
        $count = $coupon->getCount();

        if ($count === null) {
            return true;
        }

        if ($coupon->getUsed() < $count) {
            return true;
        }

        return false;
    }
}
