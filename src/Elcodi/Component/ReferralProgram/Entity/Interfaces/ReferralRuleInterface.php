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

namespace Elcodi\Component\ReferralProgram\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\ValidIntervalInterface;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;

/**
 * ReferralRule interface
 */
interface ReferralRuleInterface extends ValidIntervalInterface, EnabledInterface
{
    /**
     * Sets InvitedCoupon
     *
     * @param CouponInterface $invitedCoupon InvitedCoupon
     *
     * @return ReferralRuleInterface Self object
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
     * @return ReferralRuleInterface Self object
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
     * @return ReferralRuleInterface Self object
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
     * @return ReferralRuleInterface Self object
     */
    public function setReferrerType($referrerType);

    /**
     * Get ReferrerType
     *
     * @return string ReferrerType
     */
    public function getReferrerType();

    /**
     * Set ReferralLines
     *
     * @param Collection $referralLines Referral Lines
     *
     * @return ReferralRuleInterface Self object
     */
    public function setReferralLines(Collection $referralLines);

    /**
     * Get ReferralLines
     *
     * @return Collection ReferralLines
     */
    public function getReferralLines();
}
