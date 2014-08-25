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

namespace Elcodi\Bundle\AttributeBundle\Tests\Functional\Repository;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CouponRepositoryTest
 */
class AttributeRepository extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.attribute.repository.attribute',
            'elcodi.repository.attribute',
        ];
    }

    /**
     * Test coupon repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.attribute.repository.attribute.class'),
            $this->get('elcodi.core.attribute.repository.attribute')
        );
    }

    /**
     * Test coupon repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.attribute.repository.attribute.class'),
            $this->get('elcodi.repository.attribute')
        );
    }
}
