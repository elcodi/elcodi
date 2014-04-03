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

use Doctrine\Common\Collections\Collection;

use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\ValidIntervalTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * ReferralRule entity
 */
class ReferralRule extends AbstractEntity implements ReferralRuleInterface
{
    use ValidIntervalTrait, EnabledTrait;

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
     * @var Collection
     *
     * ReferralLines
     */
    protected $referralLines;

    /**
     * Sets InvitedCoupon
     *
     * @param CouponInterface $invitedCoupon InvitedCoupon
     *
     * @return ReferralRule Self object
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
     * @param string $invitedType InvitedType
     *
     * @return ReferralRule Self object
     */
    public function setInvitedType($invitedType)
    {
        $this->invitedType = $invitedType;

        return $this;
    }

    /**
     * Get InvitedType
     *
     * @return string InvitedType
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
     * @return ReferralRule Self object
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
     * @param string $referrerType ReferrerType
     *
     * @return ReferralRule Self object
     */
    public function setReferrerType($referrerType)
    {
        $this->referrerType = $referrerType;

        return $this;
    }

    /**
     * Get ReferrerType
     *
     * @return string ReferrerType
     */
    public function getReferrerType()
    {
        return $this->referrerType;
    }

    /**
     * Set ReferralLines
     *
     * @param Collection $referralLines Referral Lines
     *
     * @return ReferralRule Self object
     */
    public function setReferralLines(Collection $referralLines)
    {
        $this->referralLines = $referralLines;

        return $this;
    }

    /**
     * Get ReferralLines
     *
     * @return Collection ReferralLines
     */
    public function getReferralLines()
    {
        return $this->referralLines;
    }
}
