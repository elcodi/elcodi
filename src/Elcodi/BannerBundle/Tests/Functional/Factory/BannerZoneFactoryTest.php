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

namespace Elcodi\BannerBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class BannerZoneFactoryTest
 */
class BannerZoneFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.banner.factory.bannerzone',
            'elcodi.factory.bannerzone',
        ];
    }

    /**
     * Test bannerzone factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.banner.entity.bannerzone.class'),
            $this->container->get('elcodi.core.banner.entity.bannerzone.instance')
        );
    }

    /**
     * Test bannerzone factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.banner.entity.bannerzone.class'),
            $this->container->get('elcodi.entity.bannerzone.instance')
        );
    }
}
