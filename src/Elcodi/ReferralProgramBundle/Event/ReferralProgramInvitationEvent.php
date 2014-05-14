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

namespace Elcodi\ReferralProgramBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralLineInterface;
use Elcodi\ReferralProgramBundle\Entity\ReferralLine;

/**
 *
 */
class ReferralProgramInvitationEvent extends Event
{

    /**
     * @var ReferralLine
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
    public function __construct(ReferralLineInterface $referralLine, $referralLink)
    {
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
