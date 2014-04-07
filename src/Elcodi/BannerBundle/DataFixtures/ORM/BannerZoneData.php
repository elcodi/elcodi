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

use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\BannerBundle\Entity\Interfaces\BannerZoneInterface;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

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
        $bannerZone = $this->container->get('elcodi.core.banner.factory.bannerzone')->create();
        $language = $this->getReference('language-es');
        $bannerZone
            ->setName('bannerzone')
            ->setCode('bannerzone-code')
            ->setLanguage($language)
            ->setHeight(300)
            ->setWidth(400);

        $manager->persist($bannerZone);
        $this->addReference('banner-zone', $bannerZone);

        $manager->flush($bannerZone);
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
