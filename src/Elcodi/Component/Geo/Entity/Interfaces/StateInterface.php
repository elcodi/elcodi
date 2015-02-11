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
 * Interface StateInterface
 */
interface StateInterface extends EnabledInterface
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
     * @return CountryInterface Country
     */
    public function getCountry();

    /**
     * Set Country
     *
     * @param CountryInterface $country Country
     *
     * @return $this Self object
     */
    public function setCountry(CountryInterface $country);

    /**
     * Get provinces
     *
     * @return Collection Provinces
     */
    public function getProvinces();

    /**
     * Set provinces
     *
     * @param Collection $provinces Provinces
     *
     * @return $this Self object
     */
    public function setProvinces(Collection $provinces);

    /**
     * Add province
     *
     * @param ProvinceInterface $province Province
     *
     * @return $this Self object
     */
    public function addProvince(ProvinceInterface $province);

    /**
     * Add province
     *
     * @param ProvinceInterface $province Province
     *
     * @return $this Self object
     */
    public function removeProvince(ProvinceInterface $province);

    /**
     * Get Cities
     *
     * @return Collection Cities
     */
    public function getCities();

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings();

    /**
     * Return if a state is equal than current
     *
     * @param StateInterface $state State to be compared with
     *
     * @return boolean States are the same
     */
    public function equals(StateInterface $state);
}
