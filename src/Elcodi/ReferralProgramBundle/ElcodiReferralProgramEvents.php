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

namespace Elcodi\ReferralProgramBundle;

/**
 * ElcodiReferralProgramEvents
 */
class ElcodiReferralProgramEvents
{
    /**
     * This event is fired each time a user invites an email
     *
     * event.name : referral_program.invitation
     * event.class : ReferralProgramInvitationEvent
     */
    const REFERRAL_PROGRAM_INVITATION = 'referral_program.invitation';

    /**
     * This event is fired each time a coupon is assigned to a ReferralProgram
     * customer
     *
     * event.name : referral_program.coupon_assigned
     * event.class : ReferralProgramCouponAssignedEvent
     */
    const REFERRAL_PROGRAM_COUPON_ASSIGNED = 'referral_program.coupon_assigned';

    /**
     * This event is fired each time a coupon is assigned to a ReferralProgram
     * referrer
     *
     * event.name : referral_program.coupon_assigned_to_referrer
     * event.class : ReferralProgramCouponAssignedEvent
     */
    const REFERRAL_PROGRAM_COUPON_ASSIGNED_TO_REFERRER = 'referral_program.coupon_assigned_to_referrer';

    /**
     * This event is fired each time a coupon is assigned to a ReferralProgram
     * invited
     *
     * event.name : referral_program.coupon_assigned_to_invited
     * event.class : ReferralProgramCouponAssignedEvent
     */
    const REFERRAL_PROGRAM_COUPON_ASSIGNED_TO_INVITED = 'referral_program.coupon_assigned_to_invited';
}
