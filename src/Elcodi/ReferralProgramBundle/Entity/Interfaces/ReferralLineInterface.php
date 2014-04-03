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

namespace Elcodi\ReferralProgramBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\ReferralProgramBundle\Entity\ReferralHash;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * ReferralLine interface
 */
interface ReferralLineInterface extends EnabledInterface
{
    /**
     * Sets ReferralHash
     *
     * @param ReferralHashInterface $referralHash ReferralHash
     *
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @param int $invitedType InvitedType
     *
     * @return ReferralLineInterface Self object
     */
    public function setInvitedType($invitedType);

    /**
     * Get InvitedType
     *
     * @return int InvitedType
     */
    public function getInvitedType();

    /**
     * Sets ReferrerCoupon
     *
     * @param CouponInterface $referrerCoupon ReferrerCoupon
     *
     * @return ReferralLineInterface Self object
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
     * @param int $referrerType ReferrerType
     *
     * @return ReferralLineInterface Self object
     */
    public function setReferrerType($referrerType);

    /**
     * Get ReferrerType
     *
     * @return int ReferrerType
     */
    public function getReferrerType();

    /**
     * Sets InvitedAssignedCoupon
     *
     * @param CouponInterface $invitedAssignedCoupon InvitedAssignedCoupon
     *
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
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
     * @return ReferralLineInterface Self object
     */
    public function setClosed($closed);

    /**
     * Get Closed
     *
     * @return boolean Closed
     */
    public function isClosed();

    /**
     * Calculate closed variable
     */
    public function loadClosed();
}
