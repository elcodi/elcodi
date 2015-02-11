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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Class ProvinceInterface
 */
interface ProvinceInterface extends EnabledInterface
{
    /**
     * Set id
     *
     * @param string $id Id
     *
     * @return $this Self object
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return string Id
     */
    public function getId();

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return $this Self object
     */
    public function setCode($code);

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName();

    /**
     * Get Country
     *
     * @return CountryInterface $country
     */
    public function getCountry();

    /**
     * Get State
     *
     * @return StateInterface State
     */
    public function getState();

    /**
     * Set State
     *
     * @param StateInterface $state State
     *
     * @return $this Self object
     */
    public function setState(StateInterface $state);

    /**
     * Get cities
     *
     * @return Collection Cities
     */
    public function getCities();

    /**
     * Set cities
     *
     * @param Collection $cities Cities
     *
     * @return $this Self object
     */
    public function setCities(Collection $cities);

    /**
     * Add city
     *
     * @param CityInterface $city City
     *
     * @return $this Self object
     */
    public function addCity(CityInterface $city);

    /**
     * Add city
     *
     * @param CityInterface $city City
     *
     * @return $this Self object
     */
    public function removeCity(CityInterface $city);

    /**
     * Sets PostalCodes
     *
     * @param Collection $postalCodes PostalCodes
     *
     * @return $this Self object
     */
    public function setPostalCodes($postalCodes);

    /**
     * Get PostalCodes
     *
     * @return Collection PostalCodes
     */
    public function getPostalCodes();

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings();

    /**
     * Return if a province is equal than current
     *
     * @param ProvinceInterface $province Province to be compared with
     *
     * @return boolean Provinces are the same
     */
    public function equals(ProvinceInterface $province);
}
