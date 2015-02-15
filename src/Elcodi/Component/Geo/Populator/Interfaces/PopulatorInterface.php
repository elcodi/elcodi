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

namespace Elcodi\Component\Geo\Populator\Interfaces;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Interface PopulatorInterface
 *
 * @author Berny Cantos <be@rny.cc>
 */
interface PopulatorInterface
{
    /**
     * Populate a country
     *
     * @param string $countryCode Country Code
     *
     * @return LocationInterface[]
     */
    public function populate($countryCode);
}
