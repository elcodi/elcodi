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

namespace Elcodi\ProductBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\ProductBundle\Entity\Manufacturer;

/**
 * Class ManufacturerFactory
 */
class ManufacturerFactory extends AbstractFactory
{
    /**
     * Creates an instance of Manufacturer
     *
     * @return Manufacturer New Manufacturer entity
     */
    public function create()
    {
        /**
         * @var Manufacturer $manufacturer
         */
        $classNamespace = $this->getEntityNamespace();
        $manufacturer = new $classNamespace();
        $manufacturer
            ->setProducts(new ArrayCollection)
            ->setEnabled(false)
            ->setCreatedAt(new DateTime);

        return $manufacturer;
    }
}
