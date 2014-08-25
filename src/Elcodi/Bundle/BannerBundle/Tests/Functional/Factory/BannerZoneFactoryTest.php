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

namespace Elcodi\Bundle\BannerBundle\Tests\Functional\Factory;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

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
            'elcodi.core.banner.factory.banner_zone',
            'elcodi.factory.banner_zone',
        ];
    }

    /**
     * Test banner_zone factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.banner.entity.banner_zone.class'),
            $this->get('elcodi.core.banner.entity.banner_zone.instance')
        );
    }

    /**
     * Test banner_zone factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.banner.entity.banner_zone.class'),
            $this->get('elcodi.entity.banner_zone.instance')
        );
    }
}
