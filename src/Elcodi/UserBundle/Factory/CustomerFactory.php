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

namespace Elcodi\UserBundle\Factory;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\UserBundle\ElcodiUserProperties;
use Elcodi\UserBundle\Entity\Customer;

/**
 * Class CustomerFactory
 */
class CustomerFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return Customer Empty entity
     */
    public function create()
    {
        /**
         * @var Customer $customer
         */
        $classNamespace = $this->getEntityNamespace();
        $customer = new $classNamespace();
        $customer
            ->setGender(ElcodiUserProperties::GENDER_UNKNOWN)
            ->setGuest(false)
            ->setNewsletter(false)
            ->setAddresses(new ArrayCollection)
            ->setCarts(new ArrayCollection())
            ->setOrders(new ArrayCollection())
            ->setEnabled(true)
            ->setCreatedAt(new DateTime);

        return $customer;
    }
}
