<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var string
     *
     * Locations ids formatted as string
     */
    protected $locations;

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

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

    /**
     * Add location
     *
     * @param string $location Location
     *
     * @return $this Self object
     */
    public function addLocation($location)
    {
        $this->setLocations(
            array_unique(
                array_merge(
                    $this->getLocations(),
                    [$location]
                )
            )
        );

        return $this;
    }

    /**
     * Remove location
     *
     * @param string $location Location
     *
     * @return $this Self object
     */
    public function removeLocation($location)
    {
        $locations = $this->getLocations();
        $key = array_search($location, $locations);

        if ($key !== false) {
            unset($locations[$location]);
        }

        $this->setLocations($locations);

        return $this;
    }
}
