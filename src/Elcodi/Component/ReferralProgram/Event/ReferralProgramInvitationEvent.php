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

namespace Elcodi\Component\ReferralProgram\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface;
use Elcodi\Component\ReferralProgram\Entity\ReferralLine;

/**
 *
 */
class ReferralProgramInvitationEvent extends Event
{
    /**
     * @var ReferralLineInterface
     *
     * referralLine
     */
    protected $referralLine;

    /**
     * @var string
     *
     * referral link
     */
    protected $referralLink;

    /**
     * @param ReferralLineInterface $referralLine Referral line
     * @param string                $referralLink Referral link
     */
    public function __construct(
        ReferralLineInterface $referralLine,
        $referralLink
    ) {
        $this->referralLine = $referralLine;
        $this->referralLink = $referralLink;
    }

    /**
     * Get ReferralLine
     *
     * @return ReferralLine ReferralLine
     */
    public function getReferralLine()
    {
        return $this->referralLine;
    }

    /**
     * Get ReferralLink
     *
     * @return string ReferralLink
     */
    public function getReferralLink()
    {
        return $this->referralLink;
    }
}
