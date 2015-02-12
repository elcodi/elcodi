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

namespace Elcodi\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\User\Factory\CustomerFactory;

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
         * @var CustomerFactory $customerFactory
         */
        $customerObjectManager = $this->getObjectManager('customer');
        $customerFactory = $this->getFactory('customer');

        /**
         * Customer 1
         */
        $customer1 = $customerFactory
            ->create()
            ->setPassword('customer')
            ->setEmail('customer@customer.com');

        $customerObjectManager->persist($customer1);
        $this->addReference('customer-1', $customer1);

        /**
         * Customer 2
         */
        $customer2 = $customerFactory
            ->create()
            ->setPassword('customer2')
            ->setEmail('customer2@customer.com');

        $customerObjectManager->persist($customer2);
        $this->addReference('customer-2', $customer2);

        $customerObjectManager->flush([
            $customer1,
            $customer2,
        ]);
    }
}
