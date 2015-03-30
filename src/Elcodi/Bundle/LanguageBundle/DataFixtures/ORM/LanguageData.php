<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Bundle\LanguageBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Language\Factory\LanguageFactory;

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
         * @var LanguageFactory $languageFactory
         */
        $languageFactory = $this->getFactory('language');
        $languageObjectManager = $this->getObjectManager('language');

        $languageEs = $languageFactory
            ->create()
            ->setIso('es')
            ->setname('Español')
            ->setEnabled(true);

        $languageObjectManager->persist($languageEs);
        $this->addReference('language-es', $languageEs);

        $languageEn = $languageFactory
            ->create()
            ->setIso('en')
            ->setname('English')
            ->setEnabled(true);

        $languageObjectManager->persist($languageEn);
        $this->addReference('language-en', $languageEn);

        $languageFr = $languageFactory
            ->create()
            ->setIso('fr')
            ->setname('Français')
            ->setEnabled(true);

        $languageObjectManager->persist($languageFr);
        $this->addReference('language-fr', $languageFr);

        $languageIt = $languageFactory
            ->create()
            ->setIso('it')
            ->setname('Italiano')
            ->setEnabled(true);

        $languageObjectManager->persist($languageIt);
        $this->addReference('language-it', $languageIt);

        $languageDe = $languageFactory
            ->create()
            ->setIso('de')
            ->setname('Deutch')
            ->setEnabled(true);

        $languageObjectManager->persist($languageDe);
        $this->addReference('language-de', $languageDe);

        $languageObjectManager->flush([
            $languageEs,
            $languageEn,
            $languageFr,
            $languageIt,
            $languageDe,
        ]);
    }
}
