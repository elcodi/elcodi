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

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralHashInterface
 */
interface ReferralHashInterface extends IdentifiableInterface
{
    /**
     * Sets Referrer
     *
     * @param CustomerInterface $referrer Referrer
     *
     * @return $this Self object
     */
    public function setReferrer(CustomerInterface $referrer);

    /**
     * Get Referrer
     *
     * @return CustomerInterface Referrer
     */
    public function getReferrer();

    /**
     * Sets Hash
     *
     * @param string $hash Hash
     *
     * @return $this Self object
     */
    public function setHash($hash);

    /**
     * Get Hash
     *
     * @return string Hash
     */
    public function getHash();

    /**
     * Set ReferralLines
     *
     * @param Collection $referralLines Referral Lines
     *
     * @return $this Self object
     */
    public function setReferralLines(Collection $referralLines);

    /**
     * Get ReferralLines
     *
     * @return Collection ReferralLines
     */
    public function getReferralLines();
}
