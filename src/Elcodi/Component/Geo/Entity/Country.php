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
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberAssignableInterface;

/**
 * Language
 */
class Country implements CountryInterface, ZoneMemberAssignableInterface
{
    use EnabledTrait;

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
     * @var Collection
     *
     * States
     */
    protected $states;

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
     * Sets Code
     *
     * @param string $code Code
     *
     * @return $this self Object
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
     * @return $this self Object
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
     * Get states
     *
     * @return Collection States
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Set states
     *
     * @param Collection $states States
     *
     * @return $this self Object
     */
    public function setStates(Collection $states)
    {
        $this->states = $states;

        return $this;
    }

    /**
     * Add state
     *
     * @param StateInterface $state State
     *
     * @return $this self Object
     */
    public function addState(StateInterface $state)
    {
        if (!$this->states->contains($state)) {

            $this
                ->states
                ->add($state);
        }

        return $this;
    }

    /**
     * Add state
     *
     * @param StateInterface $state State
     *
     * @return $this self Object
     */
    public function removeState(StateInterface $state)
    {
        $this
            ->states
            ->removeElement($state);

        return $this;
    }

    /**
     * Get Provinces
     *
     * @return Collection Provinces
     */
    public function getProvinces()
    {
        return $this->provinces;
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
     * Return if a country is equal than current
     *
     * @param CountryInterface $country Country to be compared with
     *
     * @return boolean Countries are the same
     */
    public function equals(CountryInterface $country)
    {
        return $country->getCode() === $this->getCode();
    }
}
