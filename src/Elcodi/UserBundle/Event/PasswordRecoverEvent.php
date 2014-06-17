<?php

/**
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
 */

namespace Elcodi\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;

/**
 * Event fired when a customer unsubscribes from newsletter
 *
 * This event send an email to customer
 */
class PasswordRecoverEvent extends Event
{

    /**
     * @var AbstractUser
     *
     * User
     */
    protected $user;

    /**
     * Construct method
     *
     * @param AbstractUser $user User
     */
    public function __construct(AbstractUser $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return AbstractUser User
     */
    public function getUser()
    {
        return $this->user;
    }
}
