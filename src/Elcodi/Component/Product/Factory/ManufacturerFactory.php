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

namespace Elcodi\Component\Product\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Product\Entity\Manufacturer;

/**
 * Class ManufacturerFactory.
 */
class ManufacturerFactory extends AbstractFactory
{
    /**
     * Creates an instance of Manufacturer.
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
            ->setImages(new ArrayCollection())
            ->setImagesSort('')
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $manufacturer;
    }
}
