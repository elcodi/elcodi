<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\Entity\Traits;

/**
 * Class CouponAssignmentTrait
 */
trait CouponAssignmentTrait
{
    /**
     * @var \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface
     *
     * referrerCoupon
     */
    protected $referrerCoupon;

    /**
     * @var string
     *
     * referrerType
     */
    protected $referrerType;

    /**
     * @var \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface
     *
     * invitedCoupon
     */
    protected $invitedCoupon;

    /**
     * @var string
     *
     * invitedType
     */
    protected $invitedType;

    /**
     * Sets InvitedCoupon
     *
     * @param \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface $invitedCoupon InvitedCoupon
     *
     * @return Object Self object
     */
    public function setInvitedCoupon(\Elcodi\CouponBundle\Entity\Interfaces\CouponInterface $invitedCoupon = null)
    {
        $this->invitedCoupon = $invitedCoupon;

        return $this;
    }

    /**
     * Get InvitedCoupon
     *
     * @return \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface InvitedCoupon
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
     * @return Object Self object
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
     * @param \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface $referrerCoupon ReferrerCoupon
     *
     * @return Object Self object
     */
    public function setReferrerCoupon(\Elcodi\CouponBundle\Entity\Interfaces\CouponInterface $referrerCoupon = null)
    {
        $this->referrerCoupon = $referrerCoupon;

        return $this;
    }

    /**
     * Get ReferrerCoupon
     *
     * @return \Elcodi\CouponBundle\Entity\Interfaces\CouponInterface ReferrerCoupon
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
     * @return Object Self object
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
}
