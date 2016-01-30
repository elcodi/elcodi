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

namespace Elcodi\Component\Geo\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Geo\Entity\Address;

/**
 * Class AddressFactory.
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
            ->setCreatedAt($this->now());

        return $address;
    }
}
