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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Banner\Factory\BannerZoneFactory;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class BannerZoneData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var BannerZoneFactory $bannerZoneFactory
         */
        $bannerZoneFactory = $this->getFactory('banner_zone');
        $bannerZonebjectManager = $this->getObjectManager('banner_zone');

        /**
         * BannerZone
         *
         * @var LanguageInterface $language
         */
        $language = $this->getReference('language-es');
        $bannerZone = $bannerZoneFactory
            ->create()
            ->setName('bannerzone')
            ->setCode('bannerzone-code')
            ->setLanguage($language)
            ->setHeight(300)
            ->setWidth(400);

        $bannerZonebjectManager->persist($bannerZone);
        $this->addReference('banner-zone', $bannerZone);

        /**
         * BannerZone with no language
         */
        $bannerZoneNoLanguage = $bannerZoneFactory
            ->create()
            ->setName('bannerzone-nolanguage')
            ->setCode('bannerzone-code-nolanguage')
            ->setLanguage(null)
            ->setHeight(300)
            ->setWidth(400);

        $bannerZonebjectManager->persist($bannerZoneNoLanguage);
        $this->addReference('banner-zone-nolanguage', $bannerZoneNoLanguage);

        $bannerZonebjectManager->flush([
            $bannerZone,
            $bannerZoneNoLanguage,
        ]);
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
