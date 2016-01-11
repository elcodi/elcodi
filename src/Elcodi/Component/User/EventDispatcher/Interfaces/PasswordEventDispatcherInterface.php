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

namespace Elcodi\Component\User\EventDispatcher\Interfaces;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Interface PasswordEventDispatcherInterface.
 */
interface PasswordEventDispatcherInterface
{
    /**
     * Dispatch password remember event.
     *
     * @param AbstractUserInterface $user       User
     * @param string                $recoverUrl Recover url
     *
     * @return $this Self object
     */
    public function dispatchOnPasswordRememberEvent(
        AbstractUserInterface $user,
        $recoverUrl
    );

    /**
     * Dispatch password recover event.
     *
     * @param AbstractUserInterface $user User
     *
     * @return $this Self object
     */
    public function dispatchOnPasswordRecoverEvent(AbstractUserInterface $user);
}
