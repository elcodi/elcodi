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

namespace Elcodi\Component\Shipping\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Shipping\Entity\CarrierWeightRange;

/**
 * Class CarrierWeightRangeFactory
 */
class CarrierWeightRangeFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return CarrierWeightRange Empty entity
     */
    public function create()
    {
        /**
         * @var CarrierWeightRange $carrierWeightRange
         */
        $classNamespace = $this->getEntityNamespace();
        $carrierWeightRange = new $classNamespace();

        return $carrierWeightRange;
    }
}
