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

namespace Elcodi\Component\Geo\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;

/**
 * Class ProvinceFactory
 */
class ProvinceFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return ProvinceInterface Empty entity
     */
    public function create()
    {
        /**
         * @var ProvinceInterface $province
         */
        $classNamespace = $this->getEntityNamespace();
        $province = new $classNamespace();
        $province
            ->setCities(new ArrayCollection())
            ->setEnabled(true);

        return $province;
    }
}
