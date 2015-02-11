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

namespace Elcodi\Component\ReferralProgram\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Core\Entity\Traits\ValidIntervalTrait;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\Component\ReferralProgram\Entity\Traits\CouponAssignmentTrait;

/**
 * ReferralRule entity
 */
class ReferralRule implements ReferralRuleInterface
{
    use IdentifiableTrait,
        ValidIntervalTrait,
        EnabledTrait,
        CouponAssignmentTrait;

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
     * @return $this Self object
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
