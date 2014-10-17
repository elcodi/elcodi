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

namespace Elcodi\Component\Geo\Adapter\Populator;

use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Geo\Adapter\Populator\Interfaces\PopulatorAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;

/**
 * Class DummyPopulatorAdapter
 */
class DummyPopulatorAdapter implements PopulatorAdapterInterface
{
    /**
     * @var string
     *
     * Adapter name
     */
    const ADAPTER_NAME = 'none';

    /**
     * Populate a country
     *
     * @param OutputInterface $output                      The output interface
     * @param string          $countryCode                 Country Code
     * @param boolean         $sourcePackageMustbeReloaded Source package must be reloaded
     *
     * @return CountryInterface|null Country populated if created
     */
    public function populateCountry(
        OutputInterface $output,
        $countryCode,
        $sourcePackageMustbeReloaded
    )
    {
        return null;
    }
}
