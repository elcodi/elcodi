<?php

/**
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

namespace Elcodi\BannerBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class BannerZoneRepositoryTest
 */
class BannerZoneRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.banner.repository.bannerzone',
            'elcodi.repository.bannerzone',
        ];
    }

    /**
     * Test bannerzone repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.banner.repository.bannerzone.class'),
            $this->container->get('elcodi.core.banner.repository.bannerzone')
        );
    }

    /**
     * Test bannerzone repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.banner.repository.bannerzone.class'),
            $this->container->get('elcodi.repository.bannerzone')
        );
    }
}
