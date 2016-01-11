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

use Doctrine\ORM\EntityManagerInterface;

use Elcodi\Component\Geo\Adapter\LocationLoader\Interfaces\LocationLoaderAdapterInterface;

/**
 * Class LocationLoader.
 */
class LocationLoader
{
    /**
     * @var EntityManagerInterface
     *
     * Location Entity manager
     */
    private $locationEntityManager;

    /**
     * @var LocationLoaderAdapterInterface
     *
     * Location Loader adapter
     */
    private $locationLoaderAdapter;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface         $locationEntityManager Location Entity manager
     * @param LocationLoaderAdapterInterface $locationLoaderAdapter Location Loader adapter
     */
    public function __construct(
        EntityManagerInterface $locationEntityManager,
        LocationLoaderAdapterInterface $locationLoaderAdapter
    ) {
        $this->locationEntityManager = $locationEntityManager;
        $this->locationLoaderAdapter = $locationLoaderAdapter;
    }

    /**
     * Load country data.
     *
     * @param string $countryIso Country iso
     *
     * @return $this Self object
     */
    public function loadCountry($countryIso)
    {
        $content = $this
            ->locationLoaderAdapter
            ->getSqlForCountry($countryIso);

        $statement = $this
            ->locationEntityManager
            ->getConnection()
            ->prepare($content);

        $statement->execute();

        return $this;
    }
}
