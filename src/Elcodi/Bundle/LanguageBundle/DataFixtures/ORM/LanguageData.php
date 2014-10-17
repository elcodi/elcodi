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

namespace Elcodi\Bundle\LanguageBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class LanguageData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Languages
         */
        $languageFactory = $this->container->get('elcodi.core.language.factory.language');
        $languageEs = $languageFactory->create();
        $languageEs
            ->setIso('es')
            ->setname('Español');

        $manager->persist($languageEs);
        $this->addReference('language-es', $languageEs);

        $languageEn = $languageFactory->create();
        $languageEn
            ->setIso('en')
            ->setname('English');

        $manager->persist($languageEn);
        $this->addReference('language-en', $languageEn);

        $languageFr = $languageFactory->create();
        $languageFr
            ->setIso('fr')
            ->setname('Français');

        $manager->persist($languageFr);
        $this->addReference('language-fr', $languageFr);

        $languageIt = $languageFactory->create();
        $languageIt
            ->setIso('it')
            ->setname('Italiano');

        $manager->persist($languageIt);
        $this->addReference('language-it', $languageIt);

        $languageDe = $languageFactory->create();
        $languageDe
            ->setIso('de')
            ->setname('Deutch');

        $manager->persist($languageDe);
        $this->addReference('language-de', $languageDe);

        $manager->flush();
    }
}
