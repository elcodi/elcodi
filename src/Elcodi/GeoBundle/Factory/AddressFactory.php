<?php

/**
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

namespace Elcodi\GeoBundle\Factory;

use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\GeoBundle\Entity\Address;

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
     * @return Address Empty entity
     */
    public function create()
    {
        /**
         * @var Address $address
         */
        $classNamespace = $this->getEntityNamespace();
        $address = new $classNamespace();
        $address
            ->setAddressMore('')
            ->setEnabled(true)
            ->setCreatedAt(new DateTime);

        return $address;
    }
}
