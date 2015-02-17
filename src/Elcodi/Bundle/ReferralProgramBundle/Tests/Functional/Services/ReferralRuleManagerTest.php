<?php

/*
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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ReferralProgramBundle\Tests\Functional\Services;

use Doctrine\Common\Collections\Collection;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;

/**
 * Class ReferralRuleManagerTest
 */
class ReferralRuleManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.manager.referral_rule',
        ];
    }

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
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
            'ElcodiLanguageBundle',
            'ElcodiUserBundle',
            'ElcodiCurrencyBundle',
            'ElcodiCouponBundle',
            'ElcodiReferralProgramBundle',
        );
    }

    /**
     * Test getReferralHashByCustomer given an existing entry
     */
    public function testGetReferralHashByCustomerExisting()
    {
        /**
         * @var ReferralRuleInterface $referralRule
         */
        $referralRule = $this->find('referral_rule', 4);

        $this
            ->get('elcodi.manager.referral_rule')
            ->enableReferralRule($referralRule);

        /**
         * @var Collection $referralRules
         */
        $referralRules = $this->findAll('referral_rule');
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
