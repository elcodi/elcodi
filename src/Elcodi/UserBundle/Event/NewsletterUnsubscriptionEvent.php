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

namespace Elcodi\UserBundle\Event;

use Elcodi\UserBundle\Event\Abstracts\AbstractNewsletterEvent;

/**
 * Event fired when a customer unsubscribes from newsletter
 *
 * This event send an email to customer
 */
class NewsletterUnsubscriptionEvent extends AbstractNewsletterEvent
{
}
