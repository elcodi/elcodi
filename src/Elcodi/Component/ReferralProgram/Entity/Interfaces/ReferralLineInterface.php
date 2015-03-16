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

namespace Elcodi\Component\ReferralProgram\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\ReferralProgram\Entity\ReferralHash;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * ReferralLine interface
 */
interface ReferralLineInterface
    extends
    IdentifiableInterface,
    EnabledInterface,
    DateTimeInterface,
    CouponAssignmentInterface
{
    /**
     * Sets ReferralHash
     *
     * @param ReferralHashInterface $referralHash ReferralHash
     *
     * @return $this Self object
     */
    public function setReferralHash(ReferralHashInterface $referralHash);

    /**
     * Get ReferralHash
     *
     * @return ReferralHash ReferralHash
     */
    public function getReferralHash();

    /**
     * Sets ReferralRule
     *
     * @param ReferralRuleInterface $referralRule ReferralRule
     *
     * @return $this Self object
     */
    public function setReferralRule(ReferralRuleInterface $referralRule);

    /**
     * Get ReferralRule
     *
     * @return ReferralRuleInterface ReferralRule
     */
    public function getReferralRule();

    /**
     * Sets Invited
     *
     * @param CustomerInterface $invited Invited
     *
     * @return $this Self object
     */
    public function setInvited(CustomerInterface $invited);

    /**
     * Get Invited
     *
     * @return CustomerInterface Invited
     */
    public function getInvited();

    /**
     * Sets InvitedCouponUsed
     *
     * @param boolean $invitedCouponUsed InvitedCouponUsed
     *
     * @return $this Self object
     */
    public function setInvitedCouponUsed($invitedCouponUsed);

    /**
     * Get InvitedCouponUsed
     *
     * @return boolean InvitedCouponUsed
     */
    public function getInvitedCouponUsed();

    /**
     * Sets InvitedEmail
     *
     * @param string $invitedEmail InvitedEmail
     *
     * @return $this Self object
     */
    public function setInvitedEmail($invitedEmail);

    /**
     * Get InvitedEmail
     *
     * @return string InvitedEmail
     */
    public function getInvitedEmail();

    /**
     * Sets ReferrerCouponUsed
     *
     * @param boolean $referrerCouponUsed ReferrerCouponUsed
     *
     * @return $this Self object
     */
    public function setReferrerCouponUsed($referrerCouponUsed);

    /**
     * Get ReferrerCouponUsed
     *
     * @return boolean ReferrerCouponUsed
     */
    public function getReferrerCouponUsed();

    /**
     * Sets Source
     *
     * @param string $source Source
     *
     * @return $this Self object
     */
    public function setSource($source);

    /**
     * Get Source
     *
     * @return string Source
     */
    public function getSource();

    /**
     * Sets InvitedName
     *
     * @param string $invitedName InvitedName
     *
     * @return $this Self object
     */
    public function setInvitedName($invitedName);

    /**
     * Get InvitedName
     *
     * @return string InvitedName
     */
    public function getInvitedName();

    /**
     * Sets InvitedCoupon
     *
     * @param CouponInterface $invitedCoupon InvitedCoupon
     *
     * @return $this Self object
     */
    public function setInvitedCoupon(CouponInterface $invitedCoupon = null);

    /**
     * Get InvitedCoupon
     *
     * @return CouponInterface InvitedCoupon
     */
    public function getInvitedCoupon();

    /**
     * Sets InvitedType
     *
     * @param integer $invitedType InvitedType
     *
     * @return $this Self object
     */
    public function setInvitedType($invitedType);

    /**
     * Get InvitedType
     *
     * @return integer InvitedType
     */
    public function getInvitedType();

    /**
     * Sets ReferrerCoupon
     *
     * @param CouponInterface $referrerCoupon ReferrerCoupon
     *
     * @return $this Self object
     */
    public function setReferrerCoupon(CouponInterface $referrerCoupon = null);

    /**
     * Get ReferrerCoupon
     *
     * @return CouponInterface ReferrerCoupon
     */
    public function getReferrerCoupon();

    /**
     * Sets ReferrerType
     *
     * @param integer $referrerType ReferrerType
     *
     * @return $this Self object
     */
    public function setReferrerType($referrerType);

    /**
     * Get ReferrerType
     *
     * @return integer ReferrerType
     */
    public function getReferrerType();

    /**
     * Sets InvitedAssignedCoupon
     *
     * @param CouponInterface $invitedAssignedCoupon InvitedAssignedCoupon
     *
     * @return $this Self object
     */
    public function setInvitedAssignedCoupon(CouponInterface $invitedAssignedCoupon);

    /**
     * Get InvitedAssignedCoupon
     *
     * @return CouponInterface InvitedAssignedCoupon
     */
    public function getInvitedAssignedCoupon();

    /**
     * Sets ReferrerAssignedCoupon
     *
     * @param CouponInterface $referrerAssignedCoupon ReferrerAssignedCoupon
     *
     * @return $this Self object
     */
    public function setReferrerAssignedCoupon(CouponInterface $referrerAssignedCoupon);

    /**
     * Get ReferrerAssignedCoupon
     *
     * @return CouponInterface ReferrerAssignedCoupon
     */
    public function getReferrerAssignedCoupon();

    /**
     * Sets Closed
     *
     * @param boolean $closed Closed
     *
     * @return $this Self object
     */
    public function setClosed($closed);

    /**
     * Get Closed
     *
     * @return boolean ReferralLine is closed
     */
    public function isClosed();

    /**
     * Calculate closed variable
     *
     * @return $this Self object
     */
    public function loadClosed();
}
