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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\ReferralProgram\Services;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\Coupon\Entity\Coupon;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\Coupon\Services\CouponManager;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramEvents;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface;
use Elcodi\Component\ReferralProgram\Event\ReferralProgramCouponAssignedEvent;
use Elcodi\Component\ReferralProgram\Repository\ReferralLineRepository;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralCouponManager
 */
class ReferralCouponManager
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ReferralProgramManager
     *
     * ReferralProgramManager
     */
    protected $referralProgramManager;

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    protected $manager;

    /**
     * @var CouponManager
     *
     * couponManager
     */
    protected $couponManager;

    /**
     * @var ReferralLineRepository
     *
     * referralLineRepository
     */
    protected $referralLineRepository;

    /**
     * @var ReferralHashManager
     *
     * referralHashManager
     */
    protected $referralHashManager;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher        Event dispatcher
     * @param ReferralProgramManager   $referralProgramManager ReferralProgramManager
     * @param ObjectManager            $manager                Object Manager
     * @param CouponManager            $couponManager          Coupon Manager
     * @param ReferralLineRepository   $referralLineRepository ReferralLine Repository
     * @param ReferralHashManager      $referralHashManager    ReferralHash manager
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ReferralProgramManager $referralProgramManager,
        ObjectManager $manager,
        CouponManager $couponManager,
        ReferralLineRepository $referralLineRepository,
        ReferralHashManager $referralHashManager
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->referralProgramManager = $referralProgramManager;
        $this->manager = $manager;
        $this->couponManager = $couponManager;
        $this->referralLineRepository = $referralLineRepository;
        $this->referralHashManager = $referralHashManager;
    }

    /**
     * Assigns coupons to selected Customers, if needed
     *
     * @param CustomerInterface $customer Customer
     * @param string            $hash     Hash
     * @param string            $type     Type of assignment
     *
     * @return $this Self object
     */
    public function checkCouponAssignment(CustomerInterface $customer, $hash, $type)
    {
        $referralLine = $this->referralProgramManager->resolve($customer, $hash);

        /**
         * Current hash is not a generated hash or referralProgram is not activated
         */
        if (!($referralLine instanceof ReferralLineInterface)) {
            return $this;
        }

        $this
            ->checkReferrerCouponAssignment($referralLine, $type)
            ->checkInvitedCouponAssignment($referralLine, $type);

        return $this;
    }

    /**
     * Check if any of coupons applied in an order are from active referral
     * program line.
     *
     * This method check if coupon is been used as a referrer or as a invited.
     * If true, in both cases related flag is set to true.
     *
     * When both flags are true, ReferralLine turns as closed, so referral
     * process is finished.
     *
     * @param CustomerInterface $customer Customer
     * @param Collection        $coupons  Coupons
     *
     * @return $this Self object
     */
    public function checkCouponsUsed(CustomerInterface $customer, Collection $coupons)
    {
        $this
            ->checkCouponsUsedAsReferrer($customer, $coupons)
            ->checkCouponsUsedAsInvited($customer, $coupons);

        return $this;
    }

    /**
     * Referrer coupon assignment logic.
     *
     * This method try to assign a new `use and drop` coupon, if needed.
     * If a coupon is set into de ReferralLine, new one is created getting
     * same Coupon definition as original, but changing some parameters
     *
     * * Can be used only once
     * * Name is regenerated ( See CouponManager )
     * * Both specific referrer and generic event are raised.
     *
     * @param ReferralLineInterface $referralLine Referral Line
     * @param string                $type         Type of rule
     *
     * @return $this Self object
     */
    protected function checkReferrerCouponAssignment(ReferralLineInterface $referralLine, $type)
    {
        if ($referralLine->getReferrerType() != $type) {
            return $this;
        }

        /**
         * @var Coupon $couponReferrer
         */
        $couponReferrer = $referralLine->getReferrerCoupon();

        /**
         * New coupon MUST be assigned to referrer.
         */
        if ($couponReferrer instanceof CouponInterface) {
            $newCoupon = $this->couponManager->duplicateCoupon($couponReferrer);

            /**
             * As this coupon can be used once, we change number of uses.
             *
             * This variable could be defined in bundle configuration
             */
            $newCoupon->setCount(1);
            $referralLine->setReferrerAssignedCoupon($newCoupon);
            $this->manager->persist($newCoupon);
            $this->manager->flush($newCoupon);
            $this->manager->flush($referralLine);

            /**
             * Coupon assigned to referrer event is raised
             */
            $event = new ReferralProgramCouponAssignedEvent($referralLine, $newCoupon);
            $this->eventDispatcher->dispatch(ElcodiReferralProgramEvents::REFERRAL_PROGRAM_COUPON_ASSIGNED_TO_REFERRER, $event);

            $this->raiseCommonCouponAssignedEvent($referralLine, $newCoupon);
        }

        return $this;
    }

    /**
     * Invited coupon assignment logic.
     *
     * This method try to assign a new `use and drop` coupon, if needed.
     * If a coupon is set into de ReferralLine, new one is created getting
     * same Coupon definition as original, but changing some parameters
     *
     * * Can be used only once
     * * Name is regenerated ( See CouponManager )
     * * Both specific invited and generic event are raised.
     *
     * @param ReferralLineInterface $referralLine Referral Line
     * @param string                $type         Type of rule
     *
     * @return $this Self object
     */
    protected function checkInvitedCouponAssignment(ReferralLineInterface $referralLine, $type)
    {
        if ($referralLine->getInvitedType() != $type) {
            return $this;
        }

        /**
         * @var $couponInvited Coupon
         */
        $couponInvited = $referralLine->getInvitedCoupon();

        /**
         * New coupon MUST be assigned to invited.
         */
        if ($couponInvited instanceof CouponInterface) {
            $newCoupon = $this->couponManager->duplicateCoupon($couponInvited);

            /**
             * As this coupon can be used once, we change number of uses.
             *
             * This variable could be defined in bundle configuration
             */
            $newCoupon
                ->setCount(1)
                ->setEnabled(true);
            $referralLine->setInvitedAssignedCoupon($newCoupon);
            $this->manager->persist($newCoupon);
            $this->manager->flush($newCoupon);
            $this->manager->flush($referralLine);

            /**
             * Coupon assigned to invited event is raised
             */
            $event = new ReferralProgramCouponAssignedEvent($referralLine, $newCoupon);
            $this->eventDispatcher->dispatch(ElcodiReferralProgramEvents::REFERRAL_PROGRAM_COUPON_ASSIGNED_TO_INVITED, $event);

            $this->raiseCommonCouponAssignedEvent($referralLine, $newCoupon);
        }

        return $this;
    }

    /**
     * Raise common Coupon assignment event
     *
     * @param ReferralLineInterface $referralLine Referral line
     * @param CouponInterface       $coupon       Coupon
     *
     * @return $this Self object
     */
    protected function raiseCommonCouponAssignedEvent(ReferralLineInterface $referralLine, CouponInterface $coupon)
    {
        $event = new ReferralProgramCouponAssignedEvent($referralLine, $coupon);
        $this->eventDispatcher->dispatch(ElcodiReferralProgramEvents::REFERRAL_PROGRAM_COUPON_ASSIGNED, $event);

        return $this;
    }

    /**
     * Check if any of coupons applied in an order are from active referral
     * program line, being the customer, the referrer.
     *
     * As referrer, you can have lot of ReferralLine enabled and not closed, so
     * this method search for all of them
     *
     * @param CustomerInterface $customer Customer
     * @param Collection        $coupons  Coupons
     *
     * @return $this Self object
     */
    protected function checkCouponsUsedAsReferrer(CustomerInterface $customer, Collection $coupons)
    {
        $referralLines = $this
            ->referralHashManager
            ->getReferralHashByCustomer($customer)
            ->getReferralLines();

        foreach ($coupons as $coupon) {
            $this->checkCouponInReferralLineCollection($referralLines, $coupon);
        }

        return $this;
    }

    /**
     * Checks if a coupon is set in a collection of ReferralLines as referrer
     * coupon.
     *
     * @param Collection      $referralLines ReferralLine Collection
     * @param CouponInterface $coupon        Coupon
     *
     * @return $this Self object
     */
    protected function checkCouponInReferralLineCollection(Collection $referralLines, CouponInterface $coupon)
    {
        foreach ($referralLines as $referralLine) {

            /**
             * @var ReferralLineInterface $referralLine
             */
            if ($referralLine->getReferrerAssignedCoupon() == $coupon) {
                $referralLine->setReferrerCouponUsed(true);
                $this->manager->flush($referralLine);
            }
        }

        return $this;
    }

    /**
     * Check if any of coupons applied in an order are from active referral
     * program line, being the customer, the invited.
     *
     * As invited, you can only have one ReferralLine enabled and not closed, so
     * this method search for this one
     *
     * @param CustomerInterface $customer Customer
     * @param Collection        $coupons  Coupons
     *
     * @return $this Self object
     */
    protected function checkCouponsUsedAsInvited(CustomerInterface $customer, Collection $coupons)
    {
        $referralLine = $this
            ->referralLineRepository
            ->findOneByInvited($customer);

        if (!($referralLine instanceof ReferralLineInterface)) {
            return $this;
        }

        foreach ($coupons as $coupon) {

            /**
             * @var ReferralLineInterface $referralLine
             */
            if ($referralLine->getInvitedAssignedCoupon() == $coupon) {
                $referralLine->setInvitedCouponUsed(true);
                $this->manager->flush($referralLine);
            }
        }

        return $this;
    }
}
