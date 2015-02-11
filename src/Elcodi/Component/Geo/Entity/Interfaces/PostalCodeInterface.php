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
 * Interface PostalCodeInterface
 */
interface PostalCodeInterface extends EnabledInterface
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
     * Return if a $postalCode is equal than current
     *
     * @param PostalCodeInterface $postalCode PostalCode to be compared with
     *
     * @return boolean Cities are the same
     */
    public function equals(PostalcodeInterface $postalCode);
}
