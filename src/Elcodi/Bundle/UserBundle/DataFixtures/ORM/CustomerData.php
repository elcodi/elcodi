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
 */

namespace Elcodi\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * AdminData class
 *
 * Load fixtures of admin entities
 */
class CustomerData extends AbstractFixture
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
}
