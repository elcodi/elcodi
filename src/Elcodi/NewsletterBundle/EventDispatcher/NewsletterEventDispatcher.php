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

namespace Elcodi\NewsletterBundle\EventDispatcher;

use Elcodi\CoreBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\NewsletterBundle\ElcodiNewsletterEvents;
use Elcodi\NewsletterBundle\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\NewsletterBundle\Event\NewsletterSubscriptionEvent;
use Elcodi\NewsletterBundle\Event\NewsletterUnsubscriptionEvent;

/**
 * Class NewsletterEventDispatcher
 */
class NewsletterEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch subscription event
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     *
     * @return NewsletterEventDispatcher self Object
     */
    public function dispatchSubscribeEvent(NewsletterSubscriptionInterface $newsletterSubscription)
    {
        $newsletterSubscriptionEvent = new NewsletterSubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(
            ElcodiNewsletterEvents::NEWSLETTER_SUBSCRIBE,
            $newsletterSubscriptionEvent
        );

    }

    /**
     * Dispatch unsubscription event
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     *
     * @return NewsletterEventDispatcher self Object
     */
    public function dispatchUnsubscribeEvent(NewsletterSubscriptionInterface $newsletterSubscription)
    {
        $newsletterSubscriptionEvent = new NewsletterUnsubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(
            ElcodiNewsletterEvents::NEWSLETTER_UNSUBSCRIBE,
            $newsletterSubscriptionEvent
        );
    }
}
