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

namespace Elcodi\Component\ReferralProgram;

/**
 * Class ElcodiReferralProgramRuleTypes
 */
final class ElcodiReferralProgramRuleTypes
{
    /**
     * @var string
     *
     * No coupon is assigned
     */
    const TYPE_WITHOUT_COUPON = 'NO_COUPON';

    /**
     * @var integer
     *
     * Coupon is assigned on register
     */
    const TYPE_ON_REGISTER = 'COUPON_ON_REGISTER';

    /**
     * @var integer
     *
     * Coupon is assigned on first purchase
     */
    const TYPE_ON_FIRST_PURCHASE = 'COUPON_ON_FIRST_PURCHASE';
}
