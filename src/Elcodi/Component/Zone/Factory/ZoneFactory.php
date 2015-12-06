<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Zone\Entity\Zone;

/**
 * Factory for Zone entities.
 */
class ZoneFactory extends AbstractFactory
{
    /**
     * Creates an Zone instance.
     *
     * @return Zone New Zone entity
     */
    public function create()
    {
        /**
         * @var Zone $zone
         */
        $classNamespace = $this->getEntityNamespace();
        $zone = new $classNamespace();
        $zone
            ->setLocations([])
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $zone;
    }
}
