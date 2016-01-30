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

namespace Elcodi\Component\Geo\Services;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Factory\LocationFactory;

/**
 * Class LocationBuilder.
 */
class LocationBuilder
{
    /**
     * @var LocationFactory
     *
     * Location factory
     */
    private $locationFactory;

    /**
     * @var array
     *
     * Location collection
     */
    private $locations;

    /**
     * Construct.
     *
     * @param LocationFactory $locationFactory Location factory
     */
    public function __construct(LocationFactory $locationFactory)
    {
        $this->locationFactory = $locationFactory;

        $this->locations = [];
    }

    /**
     * Given a location information, create a new Location.
     *
     * @param string                 $id     Location id
     * @param string                 $name   Location name
     * @param string                 $code   Location code
     * @param string                 $type   Location type
     * @param LocationInterface|null $parent Location parent
     *
     * @return LocationInterface Location
     */
    public function addLocation(
        $id,
        $name,
        $code,
        $type,
        LocationInterface $parent = null
    ) {
        $location = isset($this->locations[$id])
            ? $this->locations[$id]
            : $this
                ->locationFactory
                ->create()
                ->setId($id)
                ->setName($name)
                ->setCode($code)
                ->setType($type);

        if ($parent instanceof LocationInterface) {
            $location->addParent($parent);
        }

        $this->locations[$id] = $location;

        return $location;
    }
}
