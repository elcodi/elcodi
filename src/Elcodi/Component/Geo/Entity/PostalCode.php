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
use Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface;

/**
 * Class PostalCode
 */
class PostalCode extends AbstractEntity implements PostalCodeInterface
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Code
     */
    protected $code;

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
     * @return $this Self object
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
     * @return $this self Object
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
     * @return $this self Object
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
     * @return $this self Object
     */
    public function removeCity(CityInterface $city)
    {
        $this
            ->cities
            ->removeElement($city);

        return $this;
    }
}
