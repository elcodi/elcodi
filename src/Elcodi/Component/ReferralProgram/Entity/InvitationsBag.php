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
     * @return $this Self object
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
     * @return $this Self object
     */
    public function addSentInvitation(Invitation $sentInvitation)
    {
        $this->sentInvitations->add($sentInvitation);

        return $this;
    }

    /**
     * Sets ErrorInvitations
     *
     * @param ArrayCollection $errorInvitations ErrorInvitations
     *
     * @return $this Self object
     */
    public function setErrorInvitations($errorInvitations)
    {
        $this->errorInvitations = $errorInvitations;

        return $this;
    }

    /**
     * Get ErrorInvitations
     *
     * @return ArrayCollection ErrorInvitations
     */
    public function getErrorInvitations()
    {
        return $this->errorInvitations;
    }

    /**
     * Sets SentInvitations
     *
     * @param ArrayCollection $sentInvitations SentInvitations
     *
     * @return $this Self object
     */
    public function setSentInvitations($sentInvitations)
    {
        $this->sentInvitations = $sentInvitations;

        return $this;
    }

    /**
     * Get SentInvitations
     *
     * @return ArrayCollection SentInvitations
     */
    public function getSentInvitations()
    {
        return $this->sentInvitations;
    }
}
