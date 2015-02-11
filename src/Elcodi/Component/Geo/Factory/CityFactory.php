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

namespace Elcodi\Component\Geo\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;

/**
 * Class CityFactory
 */
class CityFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return CityInterface Empty entity
     */
    public function create()
    {
        /**
         * @var CityInterface $city
         */
        $classNamespace = $this->getEntityNamespace();
        $city = new $classNamespace();
        $city
            ->setPostalCodes(new ArrayCollection())
            ->setEnabled(true);

        return $city;
    }
}
