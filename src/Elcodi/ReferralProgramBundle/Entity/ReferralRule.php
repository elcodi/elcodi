<?php

/**
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

namespace Elcodi\ReferralProgramBundle\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\ValidIntervalTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;
use Elcodi\ReferralProgramBundle\Entity\Traits\CouponAssignmentTrait;

/**
 * ReferralRule entity
 */
class ReferralRule extends AbstractEntity implements ReferralRuleInterface
{
    use ValidIntervalTrait, EnabledTrait, CouponAssignmentTrait;

    /**
     * @var Collection
     *
     * ReferralLines
     */
    protected $referralLines;

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
