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

/**
 * Class InvitationBagInterface
 */
interface InvitationBagInterface
{
    /**
     * Adds ErrorInvitations
     *
     * @param InvitationInterface $errorInvitation Invitation
     *
     * @return $this Self object
     */
    public function addErrorInvitation(InvitationInterface $errorInvitation);

    /**
     * Sets ErrorInvitations
     *
     * @param Collection $errorInvitations ErrorInvitations
     *
     * @return $this Self object
     */
    public function setErrorInvitations(Collection $errorInvitations);

    /**
     * Get ErrorInvitations
     *
     * @return Collection ErrorInvitations
     */
    public function getErrorInvitations();

    /**
     * Adds SentInvitations
     *
     * @param InvitationInterface $sentInvitation Invitation
     *
     * @return $this Self object
     */
    public function addSentInvitation(InvitationInterface $sentInvitation);

    /**
     * Sets SentInvitations
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $sentInvitations SentInvitations
     *
     * @return $this Self object
     */
    public function setSentInvitations($sentInvitations);

    /**
     * Get SentInvitations
     *
     * @return Collection SentInvitations
     */
    public function getSentInvitations();
}
