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

namespace Elcodi\Component\Newsletter\EventListener;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Newsletter\Event\NewsletterSubscriptionEvent;
use Elcodi\Component\Newsletter\Event\NewsletterUnsubscriptionEvent;

/**
 * Class NewsletterEventListener.
 */
class NewsletterEventListener
{
    /**
     * @var ObjectManager
     *
     * Newsletter manager
     */
    private $newsletterObjectManager;

    /**
     * Construct method.
     *
     * @param ObjectManager $newsletterObjectManager Newsletter object manager
     */
    public function __construct(ObjectManager $newsletterObjectManager)
    {
        $this->newsletterObjectManager = $newsletterObjectManager;
    }

    /**
     * Subscribed on newsletter subscription.
     *
     * @param NewsletterSubscriptionEvent $event Event
     */
    public function onNewsletterSubscribeFlush(NewsletterSubscriptionEvent $event)
    {
        $subscription = $event->getNewsletterSubscription();

        $this->newsletterObjectManager->persist($subscription);
        $this->newsletterObjectManager->flush($subscription);
    }

    /**
     * Subscribed on newsletter unsubscription.
     *
     * @param NewsletterUnsubscriptionEvent $event Event
     */
    public function onNewsletterUnsubscribeFlush(NewsletterUnsubscriptionEvent $event)
    {
        $subscription = $event->getNewsletterSubscription();

        $this->newsletterObjectManager->flush($subscription);
    }
}
