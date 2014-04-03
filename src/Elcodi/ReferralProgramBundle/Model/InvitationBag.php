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

namespace Elcodi\ReferralProgramBundle\Model;

use Elcodi\ReferralProgramBundle\Model\Interfaces\InvitationBagInterface;
use Elcodi\ReferralProgramBundle\Model\Interfaces\InvitationInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Class InvitationsBag
 */
class InvitationBag implements InvitationBagInterface
{
    /**
     * @var Collection
     *
     * Sent invitations
     */
    protected $sentInvitations;

    /**
     * @var Collection
     *
     * Invitations with errors (not sent)
     */
    protected $errorInvitations;

    /**
     * Adds ErrorInvitations
     *
     * @param InvitationInterface $errorInvitation Invitation
     *
     * @return InvitationBag Self object
     */
    public function addErrorInvitation(InvitationInterface $errorInvitation)
    {
        $this->errorInvitations->add($errorInvitation);

        return $this;
    }

    /**
     * Sets ErrorInvitations
     *
     * @param Collection $errorInvitations ErrorInvitations
     *
     * @return InvitationBag Self object
     */
    public function setErrorInvitations(Collection $errorInvitations)
    {
        $this->errorInvitations = $errorInvitations;

        return $this;
    }

    /**
     * Get ErrorInvitations
     *
     * @return Collection ErrorInvitations
     */
    public function getErrorInvitations()
    {
        return $this->errorInvitations;
    }

    /**
     * Adds SentInvitations
     *
     * @param InvitationInterface $sentInvitation Invitation
     *
     * @return InvitationBag Self object
     */
    public function addSentInvitation(InvitationInterface $sentInvitation)
    {
        $this->sentInvitations->add($sentInvitation);

        return $this;
    }

    /**
     * Sets SentInvitations
     *
     * @param Collection $sentInvitations SentInvitations
     *
     * @return InvitationBag Self object
     */
    public function setSentInvitations($sentInvitations)
    {
        $this->sentInvitations = $sentInvitations;

        return $this;
    }

    /**
     * Get SentInvitations
     *
     * @return Collection SentInvitations
     */
    public function getSentInvitations()
    {
        return $this->sentInvitations;
    }
}
