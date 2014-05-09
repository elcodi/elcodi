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

namespace Elcodi\ReferralProgramBundle\Entity;

use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralLineInterface;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralLine
 */
class ReferralLine extends AbstractEntity implements ReferralLineInterface
{
    use EnabledTrait, DateTimeTrait;

    /**
     * @var ReferralHashInterface
     *
     * Referral hash
     */
    protected $referralHash;

    /**
     * @var ReferralRuleInterface
     *
     * Rule applied
     */
    protected $referralRule;

    /**
     * @var CustomerInterface
     *
     * User invited if created
     */
    protected $invited;

    /**
     * @var string
     *
     * Invited id. This element represents invited user While is not a Customer
     */
    protected $invitedEmail;

    /**
     * @var string
     *
     * Invited Name. Plain value to describe a user invited
     */
    protected $invitedName;

    /**
     * @var string
     *
     * Source
     */
    protected $source;

    /**
     * @var boolean
     *
     * Referrer coupon used
     */
    protected $referrerCouponUsed;

    /**
     * @var boolean
     *
     * Invited coupon used
     */
    protected $invitedCouponUsed;

    /**
     * @var string
     *
     * referrerType
     */
    protected $referrerType;

    /**
     * @var CouponInterface
     *
     * referrerCoupon
     */
    protected $referrerCoupon;

    /**
     * @var CouponInterface
     *
     * referrerAssignedCoupon
     */
    protected $referrerAssignedCoupon;

    /**
     * @var string
     *
     * invitedType
     */
    protected $invitedType;

    /**
     * @var CouponInterface
     *
     * invitedCoupon
     */
    protected $invitedCoupon;

    /**
     * @var CouponInterface
     *
     * invitedAssignedCoupon
     */
    protected $invitedAssignedCoupon;

    /**
     * @var boolean
     *
     * ReferralLine is closed
     */
    protected $closed;

    /**
     * Sets ReferralHash
     *
     * @param ReferralHashInterface $referralHash ReferralHash
     *
     * @return ReferralLine Self object
     */
    public function setReferralHash(ReferralHashInterface $referralHash)
    {
        $this->referralHash = $referralHash;

        return $this;
    }

    /**
     * Get ReferralHash
     *
     * @return ReferralHash ReferralHash
     */
    public function getReferralHash()
    {
        return $this->referralHash;
    }

    /**
     * Sets ReferralRule
     *
     * @param ReferralRuleInterface $referralRule ReferralRule
     *
     * @return ReferralLine Self object
     */
    public function setReferralRule(ReferralRuleInterface $referralRule)
    {
        $this->referralRule = $referralRule;

        return $this;
    }

    /**
     * Get ReferralRule
     *
     * @return ReferralRuleInterface ReferralRule
     */
    public function getReferralRule()
    {
        return $this->referralRule;
    }

    /**
     * Sets Invited
     *
     * @param CustomerInterface $invited Invited
     *
     * @return ReferralLine Self object
     */
    public function setInvited(CustomerInterface $invited)
    {
        $this->invited = $invited;

        return $this;
    }

    /**
     * Get Invited
     *
     * @return CustomerInterface Invited
     */
    public function getInvited()
    {
        return $this->invited;
    }

    /**
     * Sets InvitedCouponUsed
     *
     * @param boolean $invitedCouponUsed InvitedCouponUsed
     *
     * @return ReferralLine Self object
     */
    public function setInvitedCouponUsed($invitedCouponUsed)
    {
        $this->invitedCouponUsed = $invitedCouponUsed;

        return $this;
    }

    /**
     * Get InvitedCouponUsed
     *
     * @return boolean InvitedCouponUsed
     */
    public function getInvitedCouponUsed()
    {
        return $this->invitedCouponUsed;
    }

    /**
     * Sets InvitedEmail
     *
     * @param string $invitedEmail InvitedEmail
     *
     * @return ReferralLine Self object
     */
    public function setInvitedEmail($invitedEmail)
    {
        $this->invitedEmail = $invitedEmail;

        return $this;
    }

    /**
     * Get InvitedEmail
     *
     * @return string InvitedEmail
     */
    public function getInvitedEmail()
    {
        return $this->invitedEmail;
    }

    /**
     * Sets ReferrerCouponUsed
     *
     * @param boolean $referrerCouponUsed ReferrerCouponUsed
     *
     * @return ReferralLine Self object
     */
    public function setReferrerCouponUsed($referrerCouponUsed)
    {
        $this->referrerCouponUsed = $referrerCouponUsed;

        return $this;
    }

    /**
     * Get ReferrerCouponUsed
     *
     * @return boolean ReferrerCouponUsed
     */
    public function getReferrerCouponUsed()
    {
        return $this->referrerCouponUsed;
    }

    /**
     * Sets Source
     *
     * @param string $source Source
     *
     * @return ReferralLine Self object
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get Source
     *
     * @return string Source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets InvitedName
     *
     * @param string $invitedName InvitedName
     *
     * @return ReferralLine Self object
     */
    public function setInvitedName($invitedName)
    {
        $this->invitedName = $invitedName;

        return $this;
    }

    /**
     * Get InvitedName
     *
     * @return string InvitedName
     */
    public function getInvitedName()
    {
        return $this->invitedName;
    }

    /**
     * Sets InvitedCoupon
     *
     * @param CouponInterface $invitedCoupon InvitedCoupon
     *
     * @return ReferralLine Self object
     */
    public function setInvitedCoupon(CouponInterface $invitedCoupon = null)
    {
        $this->invitedCoupon = $invitedCoupon;

        return $this;
    }

    /**
     * Get InvitedCoupon
     *
     * @return CouponInterface InvitedCoupon
     */
    public function getInvitedCoupon()
    {
        return $this->invitedCoupon;
    }

    /**
     * Sets InvitedType
     *
     * @param int $invitedType InvitedType
     *
     * @return ReferralLine Self object
     */
    public function setInvitedType($invitedType)
    {
        $this->invitedType = $invitedType;

        return $this;
    }

    /**
     * Get InvitedType
     *
     * @return int InvitedType
     */
    public function getInvitedType()
    {
        return $this->invitedType;
    }

    /**
     * Sets ReferrerCoupon
     *
     * @param CouponInterface $referrerCoupon ReferrerCoupon
     *
     * @return ReferralLine Self object
     */
    public function setReferrerCoupon(CouponInterface $referrerCoupon = null)
    {
        $this->referrerCoupon = $referrerCoupon;

        return $this;
    }

    /**
     * Get ReferrerCoupon
     *
     * @return CouponInterface ReferrerCoupon
     */
    public function getReferrerCoupon()
    {
        return $this->referrerCoupon;
    }

    /**
     * Sets ReferrerType
     *
     * @param int $referrerType ReferrerType
     *
     * @return ReferralLine Self object
     */
    public function setReferrerType($referrerType)
    {
        $this->referrerType = $referrerType;

        return $this;
    }

    /**
     * Get ReferrerType
     *
     * @return int ReferrerType
     */
    public function getReferrerType()
    {
        return $this->referrerType;
    }

    /**
     * Sets InvitedAssignedCoupon
     *
     * @param CouponInterface $invitedAssignedCoupon InvitedAssignedCoupon
     *
     * @return ReferralLine Self object
     */
    public function setInvitedAssignedCoupon(CouponInterface $invitedAssignedCoupon)
    {
        $this->invitedAssignedCoupon = $invitedAssignedCoupon;

        return $this;
    }

    /**
     * Get InvitedAssignedCoupon
     *
     * @return CouponInterface InvitedAssignedCoupon
     */
    public function getInvitedAssignedCoupon()
    {
        return $this->invitedAssignedCoupon;
    }

    /**
     * Sets ReferrerAssignedCoupon
     *
     * @param CouponInterface $referrerAssignedCoupon ReferrerAssignedCoupon
     *
     * @return ReferralLine Self object
     */
    public function setReferrerAssignedCoupon(CouponInterface $referrerAssignedCoupon)
    {
        $this->referrerAssignedCoupon = $referrerAssignedCoupon;

        return $this;
    }

    /**
     * Get ReferrerAssignedCoupon
     *
     * @return CouponInterface ReferrerAssignedCoupon
     */
    public function getReferrerAssignedCoupon()
    {
        return $this->referrerAssignedCoupon;
    }

    /**
     * Sets Closed
     *
     * @param boolean $closed Closed
     *
     * @return ReferralLine Self object
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get Closed
     *
     * @return boolean Closed
     */
    public function isClosed()
    {
        return $this->closed;
    }

    /**
     * Calculate closed variable
     */
    public function loadClosed()
    {
        $this->setClosed(
            $this->getInvitedCouponUsed() &&
            $this->getReferrerCouponUsed()
        );
    }
}
