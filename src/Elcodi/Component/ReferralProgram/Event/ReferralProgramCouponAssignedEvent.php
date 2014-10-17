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

namespace Elcodi\Component\ReferralProgram\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface;

/**
 * Class ReferralProgramCouponAssignedEvent
 */
class ReferralProgramCouponAssignedEvent extends Event
{
    /**
     * @var ReferralLineInterface
     *
     * referralLine
     */
    protected $referralLine;

    /**
     * @var CouponInterface
     *
     * Coupon
     */
    protected $coupon;

    /**
     * Construct method
     *
     * @param ReferralLineInterface $referralLine Referral Line
     * @param CouponInterface       $coupon       Coupon
     */
    public function __construct(ReferralLineInterface $referralLine, CouponInterface $coupon)
    {
        $this->referralLine = $referralLine;
        $this->coupon = $coupon;
    }

    /**
     * Get Coupon
     *
     * @return CouponInterface Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * Get ReferralLine
     *
     * @return ReferralLineInterface ReferralLine
     */
    public function getReferralLine()
    {
        return $this->referralLine;
    }
}
