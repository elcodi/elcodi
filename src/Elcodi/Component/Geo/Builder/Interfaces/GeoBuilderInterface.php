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

namespace Elcodi\Component\Geo\Builder\Interfaces;

use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;

/**
 * Interface GeoBuilderInterface
 */
interface GeoBuilderInterface
{
    /**
     * Add country
     *
     * @param string $countryCode Country code
     * @param string $countryName Country name
     *
     * @return CountryInterface
     */
    public function addCountry($countryCode, $countryName);

    /**
     * Add state with the premise that the country has to be added already
     *
     * @param CountryInterface $country   Country
     * @param string           $stateCode State code
     * @param string           $stateName State name
     *
     * @return StateInterface
     */
    public function addState(CountryInterface $country, $stateCode, $stateName);

    /**
     * Add province with the premise that the state has to be added already
     *
     * @param StateInterface $state        state
     * @param string         $provinceCode Province code
     * @param string         $provinceName Province name
     *
     * @return ProvinceInterface
     */
    public function addProvince(StateInterface $state, $provinceCode, $provinceName);

    /**
     * Add a city with the premise that the province has to be added already
     *
     * @param ProvinceInterface $province Province
     * @param string            $cityName City name
     *
     * @return CityInterface
     */
    public function addCity(ProvinceInterface $province, $cityName);

    /**
     * Add a postalcode with the premise that the city has to be added already
     *
     * @param CityInterface $city           City
     * @param string        $postalCodeCode Postalcode code
     *
     * @return PostalCodeInterface
     */
    public function addPostalCode(CityInterface $city, $postalCodeCode);
}
