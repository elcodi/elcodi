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

namespace Elcodi\Component\Zone\Factory;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Zone\Entity\Zone;
use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;

/**
 * Factory for Zone entities
 */
class ZoneFactory extends AbstractFactory
{
    /**
     * Creates an Zone instance
     *
     * @return Zone New Zone entity
     */
    public function create()
    {
        /**
         * @var Zone $Zone
         */
        $classNamespace = $this->getEntityNamespace();
        $Zone = new $classNamespace();
        $Zone
            ->setLocations([])
            ->setEnabled(true)
            ->setCreatedAt(new \DateTime());

        return $Zone;
    }
}