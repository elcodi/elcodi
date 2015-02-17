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

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\ReferralProgram\Services\ReferralHashManager;
use Elcodi\Component\User\Entity\Customer;

/**
 * Class ReferralHashManagerTest
 */
class ReferralHashManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.manager.referral_hash',
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
         * @var Customer $customer
         */
        $customer = $this->find('customer', 1);

        /**
         * @var ReferralHashManager $referralHashManager
         */
        $referralHashManager = $this->get('elcodi.manager.referral_hash');
        $referralHash = $referralHashManager->getReferralHashByCustomer($customer);

        $this->assertInstanceOf('Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface', $referralHash);
        $this->assertCount(1, $this->findAll('referral_hash'));
    }

    /**
     * Test getReferralHashByCustomer assuming new entry will be created
     */
    public function testGetReferralHashByCustomerMissing()
    {
        /**
         * @var Customer $customer
         */
        $customer = $this->find('customer', 2);

        /**
         * @var ReferralHashManager $referralHashManager
         */
        $referralHashManager = $this->get('elcodi.manager.referral_hash');
        $referralHash = $referralHashManager->getReferralHashByCustomer($customer);

        $this->assertInstanceOf('Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface', $referralHash);
        $this->assertCount(2, $this->findAll('referral_hash'));
    }
}
