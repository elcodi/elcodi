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

use Elcodi\Component\ReferralProgram\Entity\Interfaces\InvitationInterface;

/**
 * Class Invitation
 */
class Invitation implements InvitationInterface
{
    /**
     * @var string
     *
     * Invited name
     */
    protected $name;

    /**
     * @var string
     *
     * Invited email
     */
    protected $email;

    /**
     * @var string
     *
     * Invited source (email, facebook, ...)
     */
    protected $source;

    /**
     * Sets Email
     *
     * @param string $email Email
     *
     * @return $this Self object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Source
     *
     * @param string $source Source
     *
     * @return $this Self object
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get Source
     *
     * @return string Source
     */
    public function getSource()
    {
        return $this->source;
    }
}
