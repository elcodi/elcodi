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

namespace Elcodi\Component\Newsletter;

/**
 * Class ElcodiNewsletterEvents.
 */
final class ElcodiNewsletterEvents
{
    /**
     * This event is fired each time a customer subscribes to a newsletter.
     *
     * event.name : newsletter.subscribe
     * event.class : NewsletterSubscriptionEvent
     */
    const NEWSLETTER_SUBSCRIBE = 'newsletter.onsubscribe';

    /**
     * This event is fired when a customer wants to unsubscribe from a newsletter.
     *
     * event.name : newsletter.unsubscribe
     * event.class : NewsletterUnsubscriptionEvent
     */
    const NEWSLETTER_UNSUBSCRIBE = 'newsletter.onunsubscribe';
}
