<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ReferralLineRepositoryTest
 */
class ReferralLineRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.referral_program.repository.referral_line',
            'elcodi.repository.referral_line',
        ];
    }

    /**
     * Test referral_line repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.repository.referral_line.class'),
            $this->container->get('elcodi.core.referral_program.repository.referral_line')
        );
    }

    /**
     * Test referral_line repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.repository.referral_line.class'),
            $this->container->get('elcodi.repository.referral_line')
        );
    }
}
