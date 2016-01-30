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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Geo\Adapter\LocationPopulator\Interfaces\LocationPopulatorAdapterInterface;

/**
 * Class LocationPopulator.
 */
class LocationPopulator
{
    /**
     * @var LocationPopulatorAdapterInterface
     *
     * Location populator adapter
     */
    private $locationPopulatorAdapter;

    /**
     * @var ObjectManager
     *
     * Object manager
     */
    private $locationObjectManager;

    /**
     * Construct.
     *
     * @param LocationPopulatorAdapterInterface $locationPopulatorAdapter
     * @param ObjectManager                     $locationObjectManager
     */
    public function __construct(
        LocationPopulatorAdapterInterface $locationPopulatorAdapter,
        ObjectManager $locationObjectManager
    ) {
        $this->locationPopulatorAdapter = $locationPopulatorAdapter;
        $this->locationObjectManager = $locationObjectManager;
    }

    /**
     * Populate the locations for the received country.
     *
     * @param string $countryCode The country code to import
     *
     * @return $this Self object
     */
    public function populateCountry($countryCode)
    {
        $rootLocation = $this
            ->locationPopulatorAdapter
            ->populate($countryCode);

        $this
            ->locationObjectManager
            ->persist($rootLocation);

        $this
            ->locationObjectManager
            ->flush($rootLocation);

        return $this;
    }
}
