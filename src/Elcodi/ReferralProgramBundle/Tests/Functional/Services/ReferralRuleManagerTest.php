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

namespace Elcodi\ReferralProgramBundle\Tests\Functional\Services;

use Doctrine\Common\Collections\Collection;

use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ReferralRuleManagerTest
 */
class ReferralRuleManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.referral_program.services.referral_rule_manager';
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
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
            'ElcodiCoreBundle',
            'ElcodiUserBundle',
            'ElcodiCouponBundle',
            'ElcodiReferralProgramBundle',
        );
    }

    /**
     * Test getReferralHashByCustomer given an existing entry
     */
    public function testGetReferralHashByCustomerExisting()
    {
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');

        /**
         * @var ReferralRuleInterface $referralRule
         */
        $referralRule = $manager->find('ElcodiReferralProgramBundle:ReferralRule', 4);

        $container
            ->get('elcodi.core.referral_program.services.referral_rule_manager')
            ->enableReferralRule($referralRule);

        /**
         * @var Collection $referralRules
         */
        $referralRules = $manager
            ->getRepository('ElcodiReferralProgramBundle:ReferralRule')
            ->findAll();
        $referralRules->removeElement($referralRule);

        $this->assertTrue($referralRule->isEnabled());
        foreach ($referralRules as $currentReferralRule) {

            /**
             * @var ReferralRuleInterface $currentReferralRule
             */
            $this->assertFalse($currentReferralRule->isEnabled());
        }
    }
}
