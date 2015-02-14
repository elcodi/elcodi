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

namespace Elcodi\Component\Geo\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Geo\Entity\Interfaces\LocationInterface;

/**
 * Address
 */
class Location implements LocationInterface
{
    use DateTimeTrait;

    /**
     * @var string
     *
     * The id
     */
    protected $id;

    /**
     * @var string
     *
     * The name
     */
    protected $name;

    /**
     * @var string
     *
     * The code
     */
    protected $code;

    /**
     * @var string
     *
     * The type
     */
    protected $type;

    /**
     * @var Collection
     *
     * The location parents
     */
    protected $parents;

    /**
     * @var Collection
     *
     * The location children
     */
    protected $children;

    /**
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id
     *
     * @param string $id The id
     *
     * @return $this Self object
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name The name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code
     *
     * @param string $code The code
     *
     * @return $this Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Gets the type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param string $type The type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the parents
     *
     * @return Collection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * Set parent locations
     *
     * @param Collection $parents Locations
     *
     * @return $this Self object
     */
    public function setParents(Collection $parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * Add parent Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function addParent(LocationInterface $location)
    {
        if (!$this->parents->contains($location)) {
            $this
                ->parents
                ->add($location);
        }

        return $this;
    }

    /**
     * Remove parentLocation
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function removeParent(LocationInterface $location)
    {
        $this
            ->parents
            ->removeElement($location);

        return $this;
    }

    /**
     * Get the children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children locations
     *
     * @param Collection $children Locations
     *
     * @return $this Self object
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Add children Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function addChildren(LocationInterface $location)
    {
        if (!$this->children->contains($location)) {
            $this
                ->children
                ->add($location);
        }

        return $this;
    }

    /**
     * Remove children Location
     *
     * @param LocationInterface $location Location
     *
     * @return $this Self object
     */
    public function removeChildren(LocationInterface $location)
    {
        $this
            ->children
            ->removeElement($location);

        return $this;
    }
}
