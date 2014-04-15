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

namespace Elcodi\ReferralProgramBundle\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralHashInterface
 */
interface ReferralHashInterface
{
    /**
     * Sets Referrer
     *
     * @param CustomerInterface $referrer Referrer
     *
     * @return ReferralHashInterface Self object
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
     * @return ReferralHashInterface Self object
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
     * @return ReferralHashInterface Self object
     */
    public function setReferralLines(Collection $referralLines);

    /**
     * Get ReferralLines
     *
     * @return Collection ReferralLines
     */
    public function getReferralLines();
}
