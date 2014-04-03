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

namespace Elcodi\ReferralProgramBundle\Model\Interfaces;

/**
 * Class InvitationInterface
 */
interface InvitationInterface
{
    /**
     * Sets Email
     *
     * @param string $email Email
     *
     * @return InvitationInterface Self object
     */
    public function setEmail($email);

    /**
     * Get Email
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return InvitationInterface Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Sets Source
     *
     * @param string $source Source
     *
     * @return InvitationInterface Self object
     */
    public function setSource($source);

    /**
     * Get Source
     *
     * @return string Source
     */
    public function getSource();
}
