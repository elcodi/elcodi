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

namespace Elcodi\Component\User;

/**
 * ElcodiUserEvents.
 */
final class ElcodiUserEvents
{
    /**
     * This event is fired when customer wants to remember his password.
     *
     * event.name : password.remember
     * event.class : PasswordRememberEvent
     */
    const PASSWORD_REMEMBER = 'password.remember';

    /**
     * This event is fired when customer wants to recover his password.
     *
     * event.name : password.recover
     * event.class : PasswordRecoverEvent
     */
    const PASSWORD_RECOVER = 'password.recover';

    /**
     * This event is fired when a user is registered.
     *
     * event.name : user.register
     * event.class : UserRegisterEvent
     */
    const ABSTRACTUSER_REGISTER = 'user.register';

    /**
     * This event is fired when customer is registered into the web.
     *
     * event.name : customer.register
     * event.class : CustomerRegisterEvent
     */
    const CUSTOMER_REGISTER = 'customer.register';

    /**
     * This event is fired when an adminuser is registered into the admin.
     *
     * event.name : adminuser.register
     * event.class : AdminUserRegisterEvent
     */
    const ADMINUSER_REGISTER = 'adminuser.register';
}
