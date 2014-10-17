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

namespace Elcodi\Bundle\BannerBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Tests BannerManager class
 */
class BannerManagerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiLanguageBundle',
            'ElcodiBannerBundle',
        );
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.banner.service.banner_manager';
    }

    /**
     * Load banners given a banner_zone with language
     */
    public function testGetBannersFromBannerZoneCode()
    {
        $language = $this
            ->getRepository('language')
            ->findOneBy(array(
                'iso' => 'es',
            ));

        $zones = $this
            ->get('elcodi.core.banner.service.banner_manager')
            ->getBannersFromBannerZoneCode('bannerzone-code', $language);

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $zones);
        $this->assertCount(1, $zones);
    }

    /**
     * Load banners given a banner_zone with language
     */
    public function testGetBannersFromBannerZoneCodeNoLanguage()
    {
        $zones = $this
            ->get('elcodi.core.banner.service.banner_manager')
            ->getBannersFromBannerZoneCode('bannerzone-code-nolanguage');

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $zones);
        $this->assertCount(1, $zones);
    }
}
