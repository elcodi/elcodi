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

namespace Elcodi\Bundle\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class BannerZoneData extends AbstractFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * BannerZone
         *
         * @var BannerZoneInterface $bannerZone
         * @var LanguageInterface $language
         */
        $bannerZone = $this->container->get('elcodi.core.banner.factory.banner_zone')->create();
        $language = $this->getReference('language-es');
        $bannerZone
            ->setName('bannerzone')
            ->setCode('bannerzone-code')
            ->setLanguage($language)
            ->setHeight(300)
            ->setWidth(400);

        $manager->persist($bannerZone);
        $this->addReference('banner-zone', $bannerZone);

         /**
         * BannerZone with no language
         *
         * @var BannerZoneInterface $bannerZoneNoLanguage
         */
        $bannerZoneNoLanguage = $this->container->get('elcodi.core.banner.factory.banner_zone')->create();
        $bannerZoneNoLanguage
            ->setName('bannerzone-nolanguage')
            ->setCode('bannerzone-code-nolanguage')
            ->setLanguage(null)
            ->setHeight(300)
            ->setWidth(400);

        $manager->persist($bannerZoneNoLanguage);
        $this->addReference('banner-zone-nolanguage', $bannerZoneNoLanguage);

        $manager->flush();
    }
}
