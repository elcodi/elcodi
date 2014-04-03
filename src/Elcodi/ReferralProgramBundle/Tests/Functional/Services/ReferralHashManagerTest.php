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

use Elcodi\ReferralProgramBundle\Services\ReferralHashManager;
use Elcodi\UserBundle\Entity\Customer;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ReferralHashManagerTest
 */
class ReferralHashManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.referral_program.services.referral_hash_manager';
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
         * @var Customer $customer
         */
        $customer = $manager
            ->getRepository('ElcodiUserBundle:Customer')
            ->find(1);

        /**
         * @var ReferralHashManager $referralHashManager
         */
        $referralHashManager = $container->get($this->getServiceCallableName());
        $referralHash = $referralHashManager->getReferralHashByCustomer($customer);

        $this->assertInstanceOf('Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface', $referralHash);
        $this->assertCount(1, $manager->getRepository('ElcodiReferralProgramBundle:ReferralHash')->findAll());
    }

    /**
     * Test getReferralHashByCustomer assuming new entry will be created
     */
    public function testGetReferralHashByCustomerMissing()
    {
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');

        /**
         * @var Customer $customer
         */
        $customer = $manager
            ->getRepository('ElcodiUserBundle:Customer')
            ->find(2);

        /**
         * @var ReferralHashManager $referralHashManager
         */
        $referralHashManager = $container->get($this->getServiceCallableName());
        $referralHash = $referralHashManager->getReferralHashByCustomer($customer);

        $this->assertInstanceOf('Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface', $referralHash);
        $this->assertCount(2, $manager->getRepository('ElcodiReferralProgramBundle:ReferralHash')->findAll());
    }
}
