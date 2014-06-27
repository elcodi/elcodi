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

namespace Elcodi\NewsletterBundle;

/**
 * Class ElcodiNewsletterEvents
 */
class ElcodiNewsletterEvents
{
    /**
     * This event is fired each time a customer subscribe to newsletter
     *
     * event.name : newsletter.subscribe
     * event.class : NewsletterSubscriptionEvent
     */
    const NEWSLETTER_SUBSCRIBE = 'newsletter.onsubscribe';

    /**
     * This event is fired when customer want unsubscribe from newsletter
     *
     * event.name : newsletter.unsubscribe
     * event.class : NewsletterUnsubscriptionEvent
     */
    const NEWSLETTER_UNSUBSCRIBE = 'newsletter.onunsubscribe';
}
