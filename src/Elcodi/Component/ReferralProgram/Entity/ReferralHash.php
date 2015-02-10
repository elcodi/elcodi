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

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralHash
 */
class ReferralHash implements ReferralHashInterface
{
    use IdentifiableTrait;

    /**
     * @var CustomerInterface
     *
     * User referrer
     */
    protected $referrer;

    /**
     * @var string
     *
     * Referral Hash
     */
    protected $hash;

    /**
     * @var Collection
     *
     * ReferralLines
     */
    protected $referralLines;

    /**
     * Sets Referrer
     *
     * @param CustomerInterface $referrer Referrer
     *
     * @return $this Self object
     */
    public function setReferrer(CustomerInterface $referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * Get Referrer
     *
     * @return CustomerInterface Referrer
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * Sets Hash
     *
     * @param string $hash Hash
     *
     * @return $this Self object
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get Hash
     *
     * @return string Hash
     */
    public function getHash()
    {
        return $this->hash;
    }

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

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->referrer;
    }
}
