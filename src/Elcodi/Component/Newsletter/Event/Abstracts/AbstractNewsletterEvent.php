<?php

/*
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

namespace Elcodi\Component\Newsletter\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;

/**
 * Event fired when a customer subscribe to newsletter
 *
 * This event send an email to customer
 */
class AbstractNewsletterEvent extends Event
{
    /**
     * @var NewsletterSubscriptionInterface
     *
     * NewsletterSubscription
     */
    protected $newsletterSubscription;

    /**
     * construct method
     *
     * @param NewsletterSubscriptionInterface $newsletterSubscription Newsletter subscription
     */
    public function __construct(NewsletterSubscriptionInterface $newsletterSubscription)
    {
        $this->newsletterSubscription = $newsletterSubscription;
    }

    /**
     * Return order
     *
     * @return NewsletterSubscriptionInterface Newsletter Subscription
     */
    public function getNewsletterSubscription()
    {
        return $this->newsletterSubscription;
    }
}
