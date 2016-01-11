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

namespace Elcodi\Bundle\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * AdminData class.
 *
 * Load fixtures of admin entities
 */
class BannerZoneData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $bannerZoneDirector
         */
        $bannerZoneDirector = $this->getDirector('banner_zone');

        /**
         * BannerZone.
         *
         * @var LanguageInterface $language
         */
        $language = $this->getReference('language-es');
        $bannerZone = $bannerZoneDirector
            ->create()
            ->setName('bannerzone')
            ->setCode('bannerzone-code')
            ->setLanguage($language)
            ->setHeight(300)
            ->setWidth(400);

        $bannerZoneDirector->save($bannerZone);
        $this->addReference('banner-zone', $bannerZone);

        /**
         * BannerZone with no language.
         */
        $bannerZoneNoLanguage = $bannerZoneDirector
            ->create()
            ->setName('bannerzone-nolanguage')
            ->setCode('bannerzone-code-nolanguage')
            ->setLanguage(null)
            ->setHeight(300)
            ->setWidth(400);

        $bannerZoneDirector->save($bannerZoneNoLanguage);
        $this->addReference('banner-zone-nolanguage', $bannerZoneNoLanguage);
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
