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

namespace Elcodi\Bundle\BannerBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Tests BannerManager class.
 */
class BannerManagerTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiLanguageBundle',
            'ElcodiBannerBundle',
        ];
    }

    /**
     * Load banners given a banner_zone with language.
     */
    public function testGetBannersFromBannerZoneCode()
    {
        $language = $this
            ->getRepository('language')
            ->findOneBy([
                'iso' => 'es',
            ]);

        $zones = $this
            ->get('elcodi.manager.banner')
            ->getBannersFromBannerZoneCode('bannerzone-code', $language);

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $zones);
        $this->assertCount(1, $zones);
    }

    /**
     * Load banners given a banner_zone with language.
     */
    public function testGetBannersFromBannerZoneCodeNoLanguage()
    {
        $zones = $this
            ->get('elcodi.manager.banner')
            ->getBannersFromBannerZoneCode('bannerzone-code-nolanguage');

        $this->assertInstanceOf('Doctrine\Common\Collections\Collection', $zones);
        $this->assertCount(1, $zones);
    }
}
