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

namespace Elcodi\Bundle\ReferralProgramBundle\Tests\Functional\Factory;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ReferralRuleFactoryTest
 */
class ReferralRuleFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.referral_program.factory.referral_rule',
            'elcodi.factory.referral_rule',
        ];
    }

    /**
     * Test referral_rule factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.referral_program.entity.referral_rule.class'),
            $this->get('elcodi.core.referral_program.entity.referral_rule.instance')
        );
    }

    /**
     * Test referral_rule factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.referral_program.entity.referral_rule.class'),
            $this->get('elcodi.entity.referral_rule.instance')
        );
    }
}
