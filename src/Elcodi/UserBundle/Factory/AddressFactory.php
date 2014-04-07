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

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\UserBundle\Entity\Address;
use Elcodi\UserBundle\Entity\Customer;

/**
 * Class AddressFactory
 */
class AddressFactory extends AbstractFactory
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
         * @var Address $address
         */
        $classNamespace = $this->getEntityNamespace();
        $address = new $classNamespace();
        $address
            ->setEnabled(true)
            ->setCreatedAt(new DateTime);

        return $address;
    }
}
