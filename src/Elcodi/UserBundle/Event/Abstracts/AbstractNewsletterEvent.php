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

namespace Elcodi\UserBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use Elcodi\UserBundle\Entity\NewsletterSubscription;

/**
 * Event fired when a customer subscribe to newsletter
 *
 * This event send an email to customer
 */
class AbstractNewsletterEvent extends Event
{

    /**
     * @var NewsletterSubscription
     *
     * NewsletterSubscription
     */
    protected $newsletterSubscription;

    /**
     * construct method
     *
     * @param NewsletterSubscription $newsletterSubscription Newslette subscription
     */
    public function __construct(NewsletterSubscription $newsletterSubscription)
    {
        $this->newsletterSubscription = $newsletterSubscription;
    }

    /**
     * Return order
     *
     * @return NewsletterSubscription
     */
    public function getNewsletterSubscription()
    {
        return $this->newsletterSubscription;
    }
}
