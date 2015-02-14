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

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;

/**
 * Interface LocationInterface
 */
interface LocationInterface extends DateTimeInterface
{
    /**
     * Gets id
     *
     * @return string
     */
    public function getId();

    /**
     * Sets the id
     *
     * @param string $id The id
     *
     * @return string
     */
    public function setId($id);

    /**
     * Gets the name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the name
     *
     * @param string $name The name
     *
     * @return string
     */
    public function setName($name);

    /**
     * Gets the code
     *
     * @return string
     */
    public function getCode();

    /**
     * Sets the code
     *
     * @param string $code The code
     *
     * @return integer
     */
    public function setCode($code);

    /**
     * Gets the type
     *
     * @return string
     */
    public function getType();

    /**
     * Sets the type
     *
     * @param string $type The type
     *
     * @return string
     */
    public function setType($type);

    /**
     * Get the parents
     *
     * @return Collection
     */
    public function getParents();

    /**
     * Set parent locations
     *
     * @param Collection $parents Locations
     *
     * @return $this Self object
     */
    public function setParents(Collection $parents);

    /**
     * Add parent Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function addParent(LocationInterface $location);

    /**
     * Remove parentLocation
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function removeParent(LocationInterface $location);

    /**
     * Get the children
     *
     * @return Collection
     */
    public function getChildren();

    /**
     * Set children locations
     *
     * @param Collection $children Locations
     *
     * @return $this Self object
     */
    public function setChildren(Collection $children);

    /**
     * Add children Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function addChildren(LocationInterface $location);

    /**
     * Remove children Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function removeChildren(LocationInterface $location);
}
