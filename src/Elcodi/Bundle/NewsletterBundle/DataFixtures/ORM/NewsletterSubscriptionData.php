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

namespace Elcodi\Bundle\NewsletterBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * Class NewsletterSubscriptionData.
 */
class NewsletterSubscriptionData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector    $newsletterSubscriptionDirector
         * @var LanguageInterface $languageEs
         */
        $newsletterSubscriptionDirector = $this->getDirector('newsletter_subscription');
        $languageEs = $this->getReference('language-es');

        $newsletterSubscription = $newsletterSubscriptionDirector
            ->create()
            ->setEmail('someemail@something.org')
            ->setLanguage($languageEs)
            ->setHash('123456789');

        $newsletterSubscriptionDirector->save($newsletterSubscription);
        $this->setReference(
            'newsletter-subscription',
            $newsletterSubscription
        );

        $newsletterSubscriptionNoLanguage = $newsletterSubscriptionDirector
            ->create()
            ->setEmail('otheemail@something.org')
            ->setHash('0000');

        $newsletterSubscriptionDirector->save($newsletterSubscriptionNoLanguage);
        $this->setReference(
            'newsletter-subscription-nolanguage',
            $newsletterSubscriptionNoLanguage
        );
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
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
