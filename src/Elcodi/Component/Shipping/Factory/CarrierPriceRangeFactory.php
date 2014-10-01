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

namespace Elcodi\Component\Shipping\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Shipping\Entity\CarrierPriceRange;

/**
 * Class CarrierPriceRangeFactory
 */
class CarrierPriceRangeFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return CarrierPriceRange Empty entity
     */
    public function create()
    {
        /**
         * @var CarrierPriceRange $carrierPriceRange
         */
        $classNamespace = $this->getEntityNamespace();
        $carrierPriceRange = new $classNamespace();

        return $carrierPriceRange;
    }
}
