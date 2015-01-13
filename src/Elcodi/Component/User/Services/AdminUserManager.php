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
 */

namespace Elcodi\Component\User\Services;

use Elcodi\Component\User\ElcodiUserEvents;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Event\AdminUserRegisterEvent;
use Elcodi\Component\User\Services\Abstracts\AbstractUserManager;

/**
 * Class AdminUserManager
 */
class AdminUserManager extends AbstractUserManager
{
    /**
     * Register new User into the web.
     * Creates new token given a user, with related Role set.
     *
     * @param AbstractUserInterface $user        User to register
     * @param string                $providerKey Provider key
     *
     * @return $this Self object
     */
    public function register(AbstractUserInterface $user, $providerKey)
    {
        parent::register($user, $providerKey);

        $event = new AdminUserRegisterEvent($user);
        $this->eventDispatcher->dispatch(
            ElcodiUserEvents::ADMINUSER_REGISTER,
            $event
        );

        return $this;
    }
}
