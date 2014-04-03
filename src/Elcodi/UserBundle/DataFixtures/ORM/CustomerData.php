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

namespace Elcodi\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\UserBundle\Entity\Customer;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class CustomerData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Customer
         */
        $customerFactory = $this->container->get('elcodi.core.user.factory.customer');
        $customer1 = $customerFactory->create();
        $customer1
            ->setUsername('customer')
            ->setPassword('customer')
            ->setEmail('customer@customer.com');
        $manager->persist($customer1);
        $this->addReference('customer-1', $customer1);

        $customer2 = $customerFactory->create();
        $customer2
            ->setUsername('customer2')
            ->setPassword('customer2')
            ->setEmail('customer2@customer.com');
        $manager->persist($customer2);
        $this->addReference('customer-2', $customer2);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
