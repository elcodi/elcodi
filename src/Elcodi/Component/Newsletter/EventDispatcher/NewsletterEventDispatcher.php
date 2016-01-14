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

namespace Elcodi\Component\Newsletter\EventDispatcher;

use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;
use Elcodi\Component\Newsletter\ElcodiNewsletterEvents;
use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\Component\Newsletter\Event\NewsletterSubscriptionEvent;
use Elcodi\Component\Newsletter\Event\NewsletterUnsubscriptionEvent;

/**
 * Class NewsletterEventDispatcher.
 */
class NewsletterEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch subscription event.
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     *
     * @return $this Self object
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
     * Dispatch unsubscription event.
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     *
     * @return $this Self object
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
