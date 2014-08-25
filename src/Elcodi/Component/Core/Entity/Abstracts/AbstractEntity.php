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

namespace Elcodi\Component\Core\Entity\Abstracts;

/**
 * Abstract Entity
 */
abstract class AbstractEntity
{
    /**
     * @var integer
     *
     * Entity id
     */
    protected $id;

    /**
     * Set id
     *
     * @param int $id Entity Id
     *
     * @return AbstractEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return int Entity identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Entity helpers.
     */

    /**
     * Returns the name of the Entity. This is useful when using inheritance and
     * we don't want to mangle with reflection to get the base class name.
     *
     * A concrete example of this is when the RouteBuilder service need to
     * automatically compose route names based con a particular Entity. If the
     * Entity is using inheritance and we want the *parent* name to be used as
     * the base name to compose the route names, we just have to override this
     * method in the child Entity class.
     *
     * See RouteBuilder::getEntityName and AbstractController child classes
     * Route annotation for more information
     *
     * @return string
     */
    public function getEntityName()
    {
        return get_class($this);
    }

    /**
     * Returns true if the class uses the trait $trait
     *
     * This is useful when checking for objects structure in
     * template files (twig)
     *
     * @param string $trait Trait
     *
     * @return bool entity has trait
     */
    public function hasTrait($trait)
    {
        if (!$trait) {
            return false;
        }

        return in_array($trait, class_uses($this));
    }

    /**
     * String representation of an entity
     *
     * @return string String representation of current entity
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}
