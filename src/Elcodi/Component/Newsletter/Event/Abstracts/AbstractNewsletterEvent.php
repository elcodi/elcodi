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

namespace Elcodi\Component\Newsletter\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;

/**
 * Event fired when a customer subscribes to newsletter.
 *
 * This event sends an email to customer
 */
class AbstractNewsletterEvent extends Event
{
    /**
     * @var NewsletterSubscriptionInterface
     *
     * NewsletterSubscription
     */
    private $newsletterSubscription;

    /**
     * construct method.
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     */
    public function __construct(NewsletterSubscriptionInterface $newsletterSubscription)
    {
        $this->newsletterSubscription = $newsletterSubscription;
    }

    /**
     * Return order.
     *
     * @return NewsletterSubscriptionInterface Newsletter Subscription
     */
    public function getNewsletterSubscription()
    {
        return $this->newsletterSubscription;
    }
}
