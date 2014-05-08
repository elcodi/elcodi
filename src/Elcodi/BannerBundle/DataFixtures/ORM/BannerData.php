<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\BannerBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\BannerBundle\Entity\Interfaces\BannerZoneInterface;
use Elcodi\BannerBundle\Entity\Interfaces\BannerInterface;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class BannerData extends AbstractFixture
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Banner
         *
         * @var BannerInterface $banner
         * @var BannerZoneInterface $bannerZone
         */
        $banner = $this->container->get('elcodi.core.banner.factory.banner')->create();
        $bannerZone = $this->getReference('banner-zone');
        $banner
            ->setName('banner')
            ->setDescription('Simple banner')
            ->addBannerZone($bannerZone)
            ->setUrl('http://myurl.com');

        $manager->persist($banner);
        $this->addReference('banner', $banner);

        /**
         * Banner no language
         *
         * @var BannerInterface $banner
         * @var BannerZoneInterface $bannerZone
         */
        $bannerNoLanguage = $this->container->get('elcodi.core.banner.factory.banner')->create();
        $bannerZoneNoLanguage = $this->getReference('banner-zone-nolanguage');
        $bannerNoLanguage
            ->setName('banner-nolanguage')
            ->setDescription('Simple banner no language')
            ->addBannerZone($bannerZoneNoLanguage)
            ->setUrl('http://myurl.com');

        $manager->persist($bannerNoLanguage);
        $this->addReference('banner-nolanguage', $bannerNoLanguage);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
