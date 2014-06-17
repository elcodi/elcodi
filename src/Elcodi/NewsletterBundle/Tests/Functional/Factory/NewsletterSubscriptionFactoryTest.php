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
        return [
            'elcodi.core.newsletter.factory.newsletter_subscription',
            'elcodi.factory.newsletter_subscription',
        ];
    }

    /**
     * Test newsletter_subscription factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.newsletter.entity.newsletter_subscription.class'),
            $this->container->get('elcodi.core.newsletter.entity.newsletter_subscription.instance')
        );
    }

    /**
     * Test newsletter_subscription factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.newsletter.entity.newsletter_subscription.class'),
            $this->container->get('elcodi.entity.newsletter_subscription.instance')
        );
    }
}
