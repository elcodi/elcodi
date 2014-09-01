<?php

/**
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

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Geo\Entity\Interfaces\CityInterface;
use Elcodi\Component\Geo\Entity\Interfaces\CountryInterface;
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;
use Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface;
use Elcodi\Component\Geo\Entity\Interfaces\StateInterface;

/**
 * Class City
 */
class City extends AbstractEntity implements CityInterface
{
    use EnabledTrait;

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
     * @var ProvinceInterface
     *
     * province
     */
    protected $province;

    /**
     * @var Collection
     *
     * Postal codes
     */
    protected $postalCodes;

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
     * Get Country
     *
     * @return CountryInterface Country
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
     * Get province
     *
     * @return ProvinceInterface Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set province
     *
     * @param ProvinceInterface $province Province
     *
     * @return $this self Object
     */
    public function setProvince(ProvinceInterface $province)
    {
        $this->province = $province;
        $this->state = $province->getState();
        $this->country = $province->getCountry();

        return $this;
    }

    /**
     * Get postalCodes
     *
     * @return Collection Postalcodes
     */
    public function getPostalCodes()
    {
        return $this->postalCodes;
    }

    /**
     * Set postalCodes
     *
     * @param Collection $postalCodes Postalcodes
     *
     * @return $this self Object
     */
    public function setPostalCodes(Collection $postalCodes)
    {
        $this->postalCodes = $postalCodes;

        return $this;
    }

    /**
     * Add postalCode
     *
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return $this self Object
     */
    public function addPostalCode(PostalCodeInterface $postalCode)
    {
        if (!$this->postalCodes->contains($postalCode)) {

            $this
                ->postalCodes
                ->add($postalCode);
        }

        return $this;
    }

    /**
     * Add postalCode
     *
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return $this self Object
     */
    public function removePostalCode(PostalCodeInterface $postalCode)
    {
        $this
            ->postalCodes
            ->removeElement($postalCode);

        return $this;
    }

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings()
    {
        return $this
            ->province
            ->getCities();
    }
}
