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
 */

namespace Elcodi\Component\Geo\Transformer;

use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;
use Elcodi\Component\Geo\Factory\LocationDataFactory;
use Elcodi\Component\Geo\ValueObject\LocationData;

/**
 * Class LocationToLocationDataTransformer
 */
class LocationToLocationDataTransformer
{
    /**
     * @var LocationDataFactory
     *
     * LocationData factory
     */
    protected $locationDataFactory;

    /**
     * Construct
     *
     * @param LocationDataFactory $locationDataFactory LocationData factory
     */
    public function __construct(LocationDataFactory $locationDataFactory)
    {
        $this->locationDataFactory = $locationDataFactory;
    }

    /**
     * Transform a Location to LocationData
     *
     * @param LocationInterface $location Location
     *
     * @return LocationData
     */
    public function transform(LocationInterface $location)
    {
        return $this
            ->locationDataFactory
            ->create(
                $location->getId(),
                $location->getName(),
                $location->getCode(),
                $location->getType()
            );
    }
}
