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
 * interface CountryInterface
 */
interface CountryInterface extends EnabledInterface
{
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
     * Get states
     *
     * @return Collection States
     */
    public function getStates();

    /**
     * Set states
     *
     * @param Collection $states States
     *
     * @return $this Self object
     */
    public function setStates(Collection $states);

    /**
     * Add state
     *
     * @param StateInterface $state State
     *
     * @return $this Self object
     */
    public function addState(StateInterface $state);

    /**
     * Add state
     *
     * @param StateInterface $state State
     *
     * @return $this Self object
     */
    public function removeState(StateInterface $state);

    /**
     * Get Provinces
     *
     * @return Collection Provinces
     */
    public function getProvinces();

    /**
     * Get Cities
     *
     * @return Collection Cities
     */
    public function getCities();

    /**
     * Return if a country is equal than current
     *
     * @param CountryInterface $country Country to be compared with
     *
     * @return boolean Countries are the same
     */
    public function equals(CountryInterface $country);
}
