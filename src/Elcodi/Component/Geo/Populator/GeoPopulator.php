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

namespace Elcodi\Component\Geo\Populator;

use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Output\OutputInterface;

use Elcodi\Component\Geo\Adapter\Populator\Interfaces\PopulatorAdapterInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;

/**
 * Class GeoPopulator
 */
class GeoPopulator
{
    /**
     * @var PopulatorAdapterInterface
     *
     * Geo Populator adapter
     */
    protected $populatorAdapter;

    /**
     * @var ObjectManager
     *
     * Country object manager
     */
    protected $countryObjectManager;

    /**
     * Construct method
     *
     * @param PopulatorAdapterInterface $populatorAdapter     Populator adapter
     * @param ObjectManager             $countryObjectManager Country object manager
     */
    public function __construct(
        PopulatorAdapterInterface $populatorAdapter,
        ObjectManager $countryObjectManager
    )
    {
        $this->populatorAdapter = $populatorAdapter;
        $this->countryObjectManager = $countryObjectManager;
    }

    /**
     * Populate geo schema given a set of country codes and flush all countries.
     *
     * This method assumes that country and all the structure is defined with
     * persist=cascade, so persisting and flushing just the country, all
     * structure will be persisted and flushed
     *
     * @param OutputInterface $output                      The output interface
     * @param array           $countryCodes                Set of country codes
     * @param boolean         $sourcePackageMustbeReloaded Source package must be reloaded
     *
     * @return self
     */
    public function populateCountries(
        OutputInterface $output,
        $countryCodes,
        $sourcePackageMustbeReloaded
    )
    {
        foreach ($countryCodes as $countryCode) {

            $country = $this
                ->populateCountry(
                    $output,
                    $countryCode,
                    $sourcePackageMustbeReloaded
                );

            if (!is_null($country)) {

                $started = new DateTime();
                $output->writeln('<header>[Geo]</header> <body>Starting flushing manager</body>');
                $this->countryObjectManager->persist($country);
                $this->countryObjectManager->flush($country);
                $this->countryObjectManager->clear($country);
                $finished = new DateTime();
                $elapsed = $finished->diff($started);
                $output->writeln('<header>[Geo]</header> <body>Manager flushed in ' . $elapsed->format('%s') . ' seconds</body>');
            }
        }

        return $this;
    }

    /**
     * Populate geo schema given a country code
     *
     * @param OutputInterface $output                      The output interface
     * @param string          $countryCode                 Country code
     * @param boolean         $sourcePackageMustbeReloaded Source package must be reloaded
     *
     * @return CountryInterface Country populated
     */
    public function populateCountry(
        OutputInterface $output,
        $countryCode,
        $sourcePackageMustbeReloaded
    )
    {
        return $this
            ->populatorAdapter
            ->populateCountry(
                $output,
                $countryCode,
                $sourcePackageMustbeReloaded
            );
    }
}
