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

namespace Elcodi\UserBundle;

/**
 * ElcodiUserEvents
 */
class ElcodiUserEvents
{

    /**
     * This event is fired each time a customer subscribe to newsletter
     *
     * event.name : newsletter.subscribe
     * event.class : NewsletterSubscriptionEvent
     */
    const NEWSLETTER_SUBSCRIBE = 'newsletter.subscribe';

    /**
     * This event is fired when customer want unsubscribe from newsletter
     *
     * event.name : newsletter.unsubscribe
     * event.class : NewsletterUnsubscriptionEvent
     */
    const NEWSLETTER_UNSUBSCRIBE = 'newsletter.unsubscribe';

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
