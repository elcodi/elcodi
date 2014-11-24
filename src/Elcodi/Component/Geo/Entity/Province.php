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

namespace Elcodi\Component\Geo\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberAssignableInterface;

/**
 * Class Province
 */
class Province implements ProvinceInterface, ZoneMemberAssignableInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Entity id
     */
    protected $id;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var CountryInterface
     *
     * Country
     */
    protected $country;

    /**
     * @var StateInterface
     *
     * State
     */
    protected $state;

    /**
     * @var Collection
     *
     * Cities
     */
    protected $cities;

    /**
     * @var Collection
     *
     * Postalcodes
     */
    protected $postalCodes;

    /**
     * Set id
     *
     * @param string $id Entity Id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string Entity identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get Country
     *
     * @return CountryInterface $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get State
     *
     * @return StateInterface State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set State
     *
     * @param StateInterface $state State
     *
     * @return self
     */
    public function setState(StateInterface $state)
    {
        $this->state = $state;
        $this->country = $state->getCountry();

        return $this;
    }

    /**
     * Get cities
     *
     * @return Collection Cities
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Set cities
     *
     * @param Collection $cities Cities
     *
     * @return self
     */
    public function setCities(Collection $cities)
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * Add city
     *
     * @param CityInterface $city City
     *
     * @return self
     */
    public function addCity(CityInterface $city)
    {
        if (!$this->cities->contains($city)) {

            $this
                ->cities
                ->add($city);
        }

        return $this;
    }

    /**
     * Add city
     *
     * @param CityInterface $city City
     *
     * @return self
     */
    public function removeCity(CityInterface $city)
    {
        $this
            ->cities
            ->removeElement($city);

        return $this;
    }

    /**
     * Sets PostalCodes
     *
     * @param Collection $postalCodes PostalCodes
     *
     * @return self
     */
    public function setPostalCodes($postalCodes)
    {
        $this->postalCodes = $postalCodes;

        return $this;
    }

    /**
     * Get PostalCodes
     *
     * @return Collection PostalCodes
     */
    public function getPostalCodes()
    {
        return $this->postalCodes;
    }

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings()
    {
        return $this
            ->state
            ->getProvinces();
    }

    /**
     * Return if a province is equal than current
     *
     * @param ProvinceInterface $province Province to be compared with
     *
     * @return boolean Provinces are the same
     */
    public function equals(ProvinceInterface $province)
    {
        return $province->getId() === $this->getId();
    }
}
