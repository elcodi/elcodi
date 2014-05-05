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

namespace Elcodi\ReferralProgramBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\ReferralProgramBundle\Entity\ReferralHash;
use Elcodi\ReferralProgramBundle\Entity\ReferralLine;

/**
 * ReferralLineRepository
 */
class ReferralLineRepository extends EntityRepository
{
    /**
     * Return all enabled and not closed ReferralLines,
     * given a referrer Customer
     *
     * @param CustomerInterface $customer Customer
     *
     * @return ArrayCollection Collection of ReferralLine
     */
    public function findFromReferrer(CustomerInterface $customer)
    {
        return new ArrayCollection(
            $this
            ->findBy(array(
                'referrer' => $customer,
                'enabled'  => true,
                'closed'   => false,
            ))
        );
    }

    /**
     * Given an invited customer, tries to find existing ReferralLine objects
     * associated.
     *
     * Lines must be enabled and not closed.
     *
     * @param CustomerInterface $customer Invited customer
     *
     * @return ReferralLine ReferralLine found
     */
    public function findOneByInvited(CustomerInterface $customer)
    {
        return $this->findOneBy(array(
            'invited' => $customer,
            'enabled' => true,
            'closed'  => false,
        ));
    }

    /**
     * Given a ReferralHash and an invited email, tries to find existing
     * ReferralLine associated.
     *
     * Line must be enabled and not closed.
     *
     * @param ReferralHash $referralHash Referral Hash
     * @param string       $invitedEmail Invited email
     *
     * @return ReferralLine ReferralLine found
     */
    public function findOneByReferralHashAndInvitedEmail(ReferralHash $referralHash, $invitedEmail)
    {
        return $this->findOneBy(array(
            'invitedEmail' => $invitedEmail,
            'referralHash' => $referralHash,
            'closed'       => false,
        ));
    }

    /**
     * Given an invited email, tries to find existing ReferralLine objects
     * associated.
     *
     * Lines must be enabled and not closed.
     *
     * @param string $invitedEmail Invited email
     *
     * @return ArrayCollection Collection of ReferralLine found
     */
    public function findByInvitedEmail($invitedEmail)
    {
        return new ArrayCollection($this->findBy(array(
            'invitedEmail' => $invitedEmail,
            'enabled'      => true,
            'closed'       => false,
        )));
    }
}
