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

namespace Elcodi\UserBundle;

/**
 * ElcodiUserEvents
 */
class ElcodiUserEvents
{
    /**
     * This event is fired when customer wants to remember his password
     *
     * event.name : password.remember
     * event.class : PasswordRememberEvent
     */
    const PASSWORD_REMEMBER = 'password.remember';

    /**
     * This event is fired when customer wants to recover his password
     *
     * event.name : password.recover
     * event.class : PasswordRecoverEvent
     */
    const PASSWORD_RECOVER = 'password.recover';

    /**
     * This event is fired when customer is registered into the web
     *
     * event.name : user.register
     * event.class : PasswordRecoverEvent
     */
    const USER_REGISTER = 'user.register';
}
