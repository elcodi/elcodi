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

namespace Elcodi\Component\Zone\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;
use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface ZoneInterface
 */
interface ZoneInterface extends IdentifiableInterface, DateTimeInterface, EnabledInterface
{
    /**
     * Get Locations
     *
     * @return mixed Locations
     */
    public function getLocations();

    /**
     * Sets Locations
     *
     * @param array $locations Locations
     *
     * @return $this Self object
     */
    public function setLocations(array $locations);

}
