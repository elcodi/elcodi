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
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberAssignableInterface;

/**
 * Class State
 */
class State implements StateInterface, ZoneMemberAssignableInterface
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
     * @var Collection
     *
     * Provinces
     */
    protected $provinces;

    /**
     * @var Collection
     *
     * Cities
     */
    protected $cities;

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
     * @return CountryInterface Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set Country
     *
     * @param CountryInterface $country Country
     *
     * @return self
     */
    public function setCountry(CountryInterface $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get provinces
     *
     * @return Collection Provinces
     */
    public function getProvinces()
    {
        return $this->provinces;
    }

    /**
     * Set provinces
     *
     * @param Collection $provinces Provinces
     *
     * @return self
     */
    public function setProvinces(Collection $provinces)
    {
        $this->provinces = $provinces;

        return $this;
    }

    /**
     * Add province
     *
     * @param ProvinceInterface $province Province
     *
     * @return self
     */
    public function addProvince(ProvinceInterface $province)
    {
        if (!$this->provinces->contains($province)) {

            $this
                ->provinces
                ->add($province);
        }

        return $this;
    }

    /**
     * Add province
     *
     * @param ProvinceInterface $province Province
     *
     * @return self
     */
    public function removeProvince(ProvinceInterface $province)
    {
        $this
            ->provinces
            ->removeElement($province);

        return $this;
    }

    /**
     * Get Cities
     *
     * @return Collection Cities
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings()
    {
        return $this
            ->country
            ->getStates();
    }

    /**
     * Return if a state is equal than current
     *
     * @param StateInterface $state State to be compared with
     *
     * @return boolean States are the same
     */
    public function equals(StateInterface $state)
    {
        return $state->getId() === $this->getId();
    }
}
