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

namespace Elcodi\Bundle\NewsletterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Newsletter\Factory\NewsletterSubscriptionFactory;

/**
 * Class NewsletterSubscriptionData
 */
class NewsletterSubscriptionData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var NewsletterSubscriptionFactory $newsletterSubscriptionFactory
         */
        $newsletterSubscriptionFactory = $this
            ->container
            ->get('elcodi.core.newsletter.factory.newsletter_subscription');

        $languageEs = $this->getReference('language-es');

        $newsletterSubscription = $newsletterSubscriptionFactory->create();
        $newsletterSubscription
            ->setEmail('someemail@something.org')
            ->setLanguage($languageEs)
            ->setHash('123456789');

        $manager->persist($newsletterSubscription);
        $this->setReference(
            'newsletter-subscription',
            $newsletterSubscription
        );

        $newsletterSubscriptionNoLanguage = $newsletterSubscriptionFactory->create();
        $newsletterSubscriptionNoLanguage
            ->setEmail('otheemail@something.org')
            ->setHash('0000');

        $manager->persist($newsletterSubscriptionNoLanguage);
        $this->setReference(
            'newsletter-subscription-nolanguage',
            $newsletterSubscriptionNoLanguage
        );

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\LanguageBundle\DataFixtures\ORM\LanguageData',
        ];
    }
}
