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

use Elcodi\Component\ReferralProgram\Entity\Interfaces\InvitationBagInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\InvitationInterface;

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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return $this Self object
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
     * @return Collection SentInvitations
     */
    public function getSentInvitations()
    {
        return $this->sentInvitations;
    }
}
