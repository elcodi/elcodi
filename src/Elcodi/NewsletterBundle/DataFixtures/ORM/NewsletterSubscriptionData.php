<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\NewsletterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\NewsletterBundle\Factory\NewsletterSubscriptionFactory;

/**
 * Class NewsletterSubscriptionData
 */
class NewsletterSubscriptionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var NewsletterSubscriptionFactory $newsletterSubscriptionFactory
         */
        $newsletterSubscriptionFactory = $this->container->get('elcodi.core.newsletter.factory.newsletter_subscription');
        $languageEs = $this->getReference('language-es');
        $newsletterSubscription = $newsletterSubscriptionFactory->create();
        $newsletterSubscription
            ->setEmail('someemail@something.org')
            ->setLanguage($languageEs)
            ->setHash('123456789');

        $manager->persist($newsletterSubscription);
        $this->setReference('newsletter-subscription', $newsletterSubscription);

        $newsletterSubscriptionNoLanguage = $newsletterSubscriptionFactory->create();
        $newsletterSubscriptionNoLanguage
            ->setEmail('otheemail@something.org')
            ->setHash('0000');

        $manager->persist($newsletterSubscriptionNoLanguage);
        $this->setReference('newsletter-subscription-nolanguage', $newsletterSubscriptionNoLanguage);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
