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
use Elcodi\Component\Banner\Entity\Interfaces\BannerZoneInterface;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * AdminData class.
 *
 * Load fixtures of admin entities
 */
class BannerData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $bannerDirector
         */
        $bannerDirector = $this->getDirector('banner');

        /**
         * Banner.
         *
         * @var BannerZoneInterface $bannerZone
         */
        $bannerZone = $this->getReference('banner-zone');
        $banner = $bannerDirector
            ->create()
            ->setName('banner')
            ->setDescription('Simple banner')
            ->addBannerZone($bannerZone)
            ->setUrl('http://myurl.com');

        $bannerDirector->save($banner);
        $this->addReference('banner', $banner);

        /**
         * Banner no language.
         *
         * @var BannerZoneInterface $bannerZone
         */
        $bannerZoneNoLanguage = $this->getReference('banner-zone-nolanguage');
        $bannerNoLanguage = $bannerDirector
            ->create()
            ->setName('banner-nolanguage')
            ->setDescription('Simple banner no language')
            ->addBannerZone($bannerZoneNoLanguage)
            ->setUrl('http://myurl.com');

        $bannerDirector->save($bannerNoLanguage);
        $this->addReference('banner-nolanguage', $bannerNoLanguage);
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
            'Elcodi\Bundle\BannerBundle\DataFixtures\ORM\BannerZoneData',
        ];
    }
}
