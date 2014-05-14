<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version  */

namespace Elcodi\NewsletterBundle\Tests\Functional\Factory;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class NewsletterSubscriptionFactoryTest
 */
class NewsletterSubscriptionFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.newsletter.factory.newsletter_subscription';
    }
}
