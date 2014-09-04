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

namespace Elcodi\Component\Geo\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface CityInterface
 */
interface CityInterface extends EnabledInterface
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
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this self Object
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
     * Get State
     *
     * @return StateInterface State
     */
    public function getState();

    /**
     * Get province
     *
     * @return ProvinceInterface Province
     */
    public function getProvince();

    /**
     * Set province
     *
     * @param ProvinceInterface $province Province
     *
     * @return $this self Object
     */
    public function setProvince(ProvinceInterface $province);

    /**
     * Get postalCodes
     *
     * @return Collection Postalcodes
     */
    public function getPostalCodes();

    /**
     * Set postalCodes
     *
     * @param Collection $postalCodes Postalcodes
     *
     * @return $this self Object
     */
    public function setPostalCodes(Collection $postalCodes);

    /**
     * Add postalCode
     *
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return $this self Object
     */
    public function addPostalCode(PostalCodeInterface $postalCode);

    /**
     * Add postalCode
     *
     * @param PostalCodeInterface $postalCode PostalCode
     *
     * @return $this self Object
     */
    public function removePostalCode(PostalCodeInterface $postalCode);

    /**
     * Get siblings
     *
     * @return Collection siblings
     */
    public function getSiblings();
}
