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

namespace Elcodi\Component\Geo\Builder;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Geo\Builder\Interfaces\GeoBuilderInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Factory\CityFactory;
use Elcodi\Component\Geo\Factory\CountryFactory;
use Elcodi\Component\Geo\Factory\PostalCodeFactory;
use Elcodi\Component\Geo\Factory\ProvinceFactory;
use Elcodi\Component\Geo\Factory\StateFactory;

/**
 * Class GeoBuilder
 */
class GeoBuilder implements GeoBuilderInterface
{
    /**
     * @var array
     *
     * Country collection
     */
    protected $countries;

    /**
     * @var array
     *
     * States
     */
    protected $states;

    /**
     * @var array
     *
     * Provinces collection
     */
    protected $provinces;

    /**
     * @var array
     *
     * Cities
     */
    protected $cities;

    /**
     * @var array
     *
     * Postalcodes
     */
    protected $postalCodes;

    /**
     * @var CountryFactory
     *
     * Country factory
     */
    protected $countryFactory;

    /**
     * @var StateFactory
     *
     * State factory
     */
    protected $stateFactory;

    /**
     * @var ProvinceFactory
     *
     * Province factory
     */
    protected $provinceFactory;

    /**
     * @var CityFactory
     *
     * City Factory
     */
    protected $cityFactory;

    /**
     * @var PostalCodeFactory
     *
     * PostalCode factory
     */
    protected $postalCodeFactory;

    /**
     * @param CountryFactory    $countryFactory    Country factory
     * @param StateFactory      $stateFactory      State factory
     * @param ProvinceFactory   $provinceFactory   Province factory
     * @param CityFactory       $cityFactory       City factory
     * @param PostalCodeFactory $postalCodeFactory PostalCode factory
     */
    public function __construct(
        CountryFactory $countryFactory,
        StateFactory $stateFactory,
        ProvinceFactory $provinceFactory,
        CityFactory $cityFactory,
        PostalCodeFactory $postalCodeFactory
    ) {
        $this->countryFactory = $countryFactory;
        $this->stateFactory = $stateFactory;
        $this->provinceFactory = $provinceFactory;
        $this->cityFactory = $cityFactory;
        $this->postalCodeFactory = $postalCodeFactory;

        $this->countries = [];
        $this->states = [];
        $this->provinces = [];
        $this->cities = [];
        $this->postalCodes = [];
    }

    /**
     * Add country
     *
     * @param string $countryCode Country code
     * @param string $countryName Country name
     *
     * @return CountryInterface
     */
    public function addCountry($countryCode, $countryName)
    {
        $countryCode = trim($countryCode);
        $countryName = trim($countryName);

        if (!isset($this->countries[$countryCode])) {
            $country = $this->countryFactory->create();
            $country
                ->setCode($countryCode)
                ->setName($countryName)
                ->setStates(new ArrayCollection())
                ->setEnabled(true);

            $this->countries[$countryCode] = $country;
        }

        return $this->countries[$countryCode];
    }

    /**
     * Add state with the premise that the country has to be added already
     *
     * @param CountryInterface $country   Country
     * @param string           $stateCode State code
     * @param string           $stateName State name
     *
     * @return StateInterface
     */
    public function addState(CountryInterface $country, $stateCode, $stateName)
    {
        $stateCode = trim($stateCode);
        $stateName = trim($stateName);
        $stateId = $country->getCode().'_'.$stateCode;

        if (!isset($this->states[$stateId])) {
            $state = $this->stateFactory->create();
            $state
                ->setId($stateId)
                ->setCode($stateCode)
                ->setName($stateName)
                ->setCountry($country)
                ->setProvinces(new ArrayCollection())
                ->setEnabled(true);
            $country->addState($state);

            $this->states[$stateId] = $state;
        }

        return $this->states[$stateId];
    }

    /**
     * Add province with the premise that the state has to be added already
     *
     * @param StateInterface $state        state
     * @param string         $provinceCode Province code
     * @param string         $provinceName Province name
     *
     * @return ProvinceInterface
     */
    public function addProvince(StateInterface $state, $provinceCode, $provinceName)
    {
        $provinceCode = trim($provinceCode);
        $provinceName = trim($provinceName);
        $provinceId = $state->getId().'_'.$provinceCode;

        if (!isset($this->provinces[$provinceId])) {
            $province = $this->provinceFactory->create();
            $province
                ->setId($provinceId)
                ->setCode($provinceCode)
                ->setName($provinceName)
                ->setState($state)
                ->setCities(new ArrayCollection())
                ->setEnabled(true);
            $state->addProvince($province);

            $this->provinces[$provinceId] = $province;
        }

        return $this->provinces[$provinceId];
    }

    /**
     * Add a city with the premise that the province has to be added already
     *
     * @param ProvinceInterface $province Province
     * @param string            $cityName City name
     *
     * @return CityInterface
     */
    public function addCity(ProvinceInterface $province, $cityName)
    {
        $cityName = trim($cityName);
        $cityId = $province->getId().'_'.preg_replace('/[^\da-z]/i', '', strtolower($cityName));

        if (!isset($this->cities[$cityId])) {
            $city = $this->cityFactory->create();
            $city
                ->setId($cityId)
                ->setName($cityName)
                ->setProvince($province)
                ->setPostalCodes(new ArrayCollection())
                ->setEnabled(true);
            $province->addCity($city);

            $this->cities[$cityId] = $city;
        }

        return $this->cities[$cityId];
    }

    /**
     * Add a postalcode with the premise that the city has to be added already
     *
     * @param CityInterface $city           City
     * @param string        $postalCodeCode Postalcode code
     *
     * @return PostalCodeInterface
     */
    public function addPostalCode(CityInterface $city, $postalCodeCode)
    {
        $postalCodeCode = trim($postalCodeCode);
        $cityCountry = $city->getCountry();

        $postalCodeId = $cityCountry->getCode().'_'.trim($postalCodeCode);

        if (!isset($this->postalCodes[$postalCodeId])) {
            $postalCode = $this->postalCodeFactory->create();
            $postalCode
                ->setId($postalCodeId)
                ->setCode($postalCodeCode)
                ->setCities(new ArrayCollection())
                ->addCity($city)
                ->setEnabled(true);
            $city->addPostalCode($postalCode);

            $this->postalCodes[$postalCodeId] = $postalCode;
        }

        return $this->postalCodes[$postalCodeId];
    }
}
