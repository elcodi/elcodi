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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InvitationsBag
 */
class InvitationsBag
{
    /**
     * @var ArrayCollection
     *
     * Sent invitations
     */
    protected $sentInvitations;

    /**
     * @var ArrayCollection
     *
     * Invitations with errors (not sent)
     */
    protected $errorInvitations;

    /**
     * Adds ErrorInvitations
     *
     * @param Invitation $errorInvitation Invitation
     *
     * @return InvitationsBag Self object
     */
    public function addErrorInvitation(Invitation $errorInvitation)
    {
        $this->errorInvitations->add($errorInvitation);

        return $this;
    }

    /**
     * Adds SentInvitations
     *
     * @param Invitation $sentInvitation Invitation
     *
     * @return InvitationsBag Self object
     */
    public function addSentInvitation(Invitation $sentInvitation)
    {
        $this->sentInvitations->add($sentInvitation);

        return $this;
    }

    /**
     * Sets ErrorInvitations
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $errorInvitations ErrorInvitations
     *
     * @return InvitationsBag Self object
     */
    public function setErrorInvitations($errorInvitations)
    {
        $this->errorInvitations = $errorInvitations;

        return $this;
    }

    /**
     * Get ErrorInvitations
     *
     * @return \Doctrine\Common\Collections\ArrayCollection ErrorInvitations
     */
    public function getErrorInvitations()
    {
        return $this->errorInvitations;
    }

    /**
     * Sets SentInvitations
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $sentInvitations SentInvitations
     *
     * @return InvitationsBag Self object
     */
    public function setSentInvitations($sentInvitations)
    {
        $this->sentInvitations = $sentInvitations;

        return $this;
    }

    /**
     * Get SentInvitations
     *
     * @return \Doctrine\Common\Collections\ArrayCollection SentInvitations
     */
    public function getSentInvitations()
    {
        return $this->sentInvitations;
    }
}
