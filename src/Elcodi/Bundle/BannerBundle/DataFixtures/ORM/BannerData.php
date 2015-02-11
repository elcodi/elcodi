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
use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Banner\Factory\BannerFactory;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class BannerData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var BannerFactory $bannerFactory
         */
        $bannerFactory = $this->getFactory('banner');
        $bannerObjectManager = $this->getObjectManager('banner');

        /**
         * Banner
         *
         * @var BannerZoneInterface $bannerZone
         */
        $bannerZone = $this->getReference('banner-zone');
        $banner = $bannerFactory
            ->create()
            ->setName('banner')
            ->setDescription('Simple banner')
            ->addBannerZone($bannerZone)
            ->setUrl('http://myurl.com');

        $bannerObjectManager->persist($banner);
        $this->addReference('banner', $banner);

        /**
         * Banner no language
         *
         * @var BannerZoneInterface $bannerZone
         */
        $bannerZoneNoLanguage = $this->getReference('banner-zone-nolanguage');
        $bannerNoLanguage = $bannerFactory
            ->create()
            ->setName('banner-nolanguage')
            ->setDescription('Simple banner no language')
            ->addBannerZone($bannerZoneNoLanguage)
            ->setUrl('http://myurl.com');

        $bannerObjectManager->persist($bannerNoLanguage);
        $this->addReference('banner-nolanguage', $bannerNoLanguage);

        $bannerObjectManager->flush([
            $banner,
            $bannerNoLanguage,
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
            'Elcodi\Bundle\BannerBundle\DataFixtures\ORM\BannerZoneData',
        ];
    }
}
