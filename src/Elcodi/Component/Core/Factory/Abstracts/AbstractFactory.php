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

namespace Elcodi\Component\Core\Factory\Abstracts;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;

/**
 * Class AbstractFactory
 *
 * Entity factories create a pristine instance for the specified Entity
 *
 * Entity initialization logic should be placed right here.
 *
 * Injected entity namespace should not be duplicated.
 */
abstract class AbstractFactory
{
    /**
     * @var string
     *
     * Entity namespace
     */
    protected $entityNamespace;

    /**
     * Set Entity Namespace
     *
     * @param string $entityNamespace Entity namespace
     *
     * @return AbstractFactory self Object
     */
    public function setEntityNamespace($entityNamespace)
    {
        $this->entityNamespace = $entityNamespace;

        return $this;
    }

    /**
     * Get entity Namespace
     *
     * @return string Entity Namespace
     */
    public function getEntityNamespace()
    {
        return $this->entityNamespace;
    }

    /**
     * Creates an instance of an entity.
     *
     * Queries should be implemented in a repository class
     *
     * This method must always returns an empty instance of the related Entity
     * and initializes it in a consistent state
     *
     * @return AbstractEntity Empty entity
     */
    abstract public function create();
}
