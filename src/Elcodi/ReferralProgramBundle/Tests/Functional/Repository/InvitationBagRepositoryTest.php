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

namespace Elcodi\ReferralProgramBundle\Tests\Functional\Repository;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class InvitationBagRepositoryTest
 */
class InvitationBagRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.referral_program.repository.invitation_bag',
            'elcodi.repository.invitation_bag',
        ];
    }

    /**
     * Test invitation_bag repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.repository.invitation_bag.class'),
            $this->container->get('elcodi.core.referral_program.repository.invitation_bag')
        );
    }

    /**
     * Test invitation_bag repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.referral_program.repository.invitation_bag.class'),
            $this->container->get('elcodi.repository.invitation_bag')
        );
    }
}
