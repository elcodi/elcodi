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

namespace Elcodi\Bundle\LanguageBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * AdminData class.
 *
 * Load fixtures of admin entities
 */
class LanguageData extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $languageDirector
         */
        $languageDirector = $this->getDirector('language');

        $languageEs = $languageDirector
            ->create()
            ->setIso('es')
            ->setname('Español')
            ->setEnabled(true);

        $languageDirector->save($languageEs);
        $this->addReference('language-es', $languageEs);

        $languageEn = $languageDirector
            ->create()
            ->setIso('en')
            ->setname('English')
            ->setEnabled(true);

        $languageDirector->save($languageEn);
        $this->addReference('language-en', $languageEn);

        $languageFr = $languageDirector
            ->create()
            ->setIso('fr')
            ->setname('Français')
            ->setEnabled(true);

        $languageDirector->save($languageFr);
        $this->addReference('language-fr', $languageFr);

        $languageIt = $languageDirector
            ->create()
            ->setIso('it')
            ->setname('Italiano')
            ->setEnabled(true);

        $languageDirector->save($languageIt);
        $this->addReference('language-it', $languageIt);

        $languageDe = $languageDirector
            ->create()
            ->setIso('de')
            ->setname('Deutch')
            ->setEnabled(true);

        $languageDirector->save($languageDe);
        $this->addReference('language-de', $languageDe);
    }
}
