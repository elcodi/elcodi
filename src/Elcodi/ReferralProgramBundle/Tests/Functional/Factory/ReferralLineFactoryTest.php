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

namespace Elcodi\ReferralProgramBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ReferralLineFactoryTest
 */
class ReferralLineFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.referral_program.factory.referral_line',
            'elcodi.factory.referral_line',
        ];
    }

    /**
     * Test referral_line factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.entity.referral_line.class'),
            $this->container->get('elcodi.core.referral_program.entity.referral_line.instance')
        );
    }

    /**
     * Test referral_line factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.entity.referral_line.class'),
            $this->container->get('elcodi.entity.referral_line.instance')
        );
    }
}
