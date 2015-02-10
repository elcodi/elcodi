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

use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * Interface CouponAssignmentInterface
 */
interface CouponAssignmentInterface
{
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
     * @param string $invitedType InvitedType
     *
     * @return $this Self object
     */
    public function setInvitedType($invitedType);

    /**
     * Get InvitedType
     *
     * @return string InvitedType
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
     * @param string $referrerType ReferrerType
     *
     * @return $this Self object
     */
    public function setReferrerType($referrerType);

    /**
     * Get ReferrerType
     *
     * @return string ReferrerType
     */
    public function getReferrerType();
}
