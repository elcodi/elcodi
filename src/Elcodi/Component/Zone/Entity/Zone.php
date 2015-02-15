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

namespace Elcodi\Component\Zone\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;

/**
 * Class Zone
 */
class Zone implements ZoneInterface
{
    use IdentifiableTrait, DateTimeTrait, EnabledTrait;

    /**
     * @var array
     *
     * Locations ids
     */
    protected $locations;

    /**
     * Get Locations
     *
     * @return array Locations
     */
    public function getLocations()
    {
        return explode(',', $this->locations);
    }

    /**
     * Sets Locations
     *
     * @param array $locations Locations
     *
     * @return $this Self object
     */
    public function setLocations(array $locations)
    {
        $this->locations = implode(',', $locations);

        return $this;
    }
}
