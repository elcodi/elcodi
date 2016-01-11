<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\User\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\User\ElcodiUserEvents;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Event\PasswordRecoverEvent;
use Elcodi\Component\User\Event\PasswordRememberEvent;
use Elcodi\Component\User\EventDispatcher\Interfaces\PasswordEventDispatcherInterface;

/**
 * Class PasswordEventDispatcher.
 */
class PasswordEventDispatcher extends AbstractEventDispatcher implements PasswordEventDispatcherInterface
{
    /**
     * Dispatch password remember event.
     *
     * @param AbstractUserInterface $user       User
     * @param string                $recoverUrl Recover url
     *
     * @return $this Self object
     */
    public function dispatchOnPasswordRememberEvent(AbstractUserInterface $user, $recoverUrl)
    {
        $event = new PasswordRememberEvent($user, $recoverUrl);
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiUserEvents::PASSWORD_REMEMBER,
                $event
            );
    }

    /**
     * Dispatch password recover event.
     *
     * @param AbstractUserInterface $user User
     *
     * @return $this Self object
     */
    public function dispatchOnPasswordRecoverEvent(AbstractUserInterface $user)
    {
        $event = new PasswordRecoverEvent($user);
        $this
            ->eventDispatcher
            ->dispatch(
                ElcodiUserEvents::PASSWORD_RECOVER,
                $event
            );
    }
}
