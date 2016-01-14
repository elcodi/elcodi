<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * AdminData class.
 *
 * Load fixtures of admin entities
 */
class CustomerData extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $customerDirector
         */
        $customerDirector = $this->getDirector('customer');

        /**
         * Customer 1.
         */
        $customer1 = $customerDirector
            ->create()
            ->setPassword('customer')
            ->setEmail('customer@customer.com');

        $customerDirector->save($customer1);
        $this->addReference('customer-1', $customer1);

        /**
         * Customer 2.
         */
        $customer2 = $customerDirector
            ->create()
            ->setPassword('customer2')
            ->setEmail('customer2@customer.com');

        $customerDirector->save($customer2);
        $this->addReference('customer-2', $customer2);
    }
}
