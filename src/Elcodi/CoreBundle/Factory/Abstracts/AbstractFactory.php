<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CoreBundle\Factory\Abstracts;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;

/**
 * Class AbstractFactory
 *
 * Entity factories creates a new, simple and clean instance of specified entity
 * by using new() PHP method.
 *
 * All initialization of entity should be placed right here.
 *
 * Also entity namespace should be injected and should not be duplicated.
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
    protected function getEntityNamespace()
    {
        return $this->entityNamespace;
    }

    /**
     * Creates an instance of an entity.
     * All entity querying logic should be placed in a repository, and all
     * creational logic in a factory class.
     *
     * This method must return always an empty instance for related entity,
     * initialized as expected by documentation.
     *
     * If original entity is overwritten and new Implementation has the same
     * construct behaviour, this method should not be overwritten.
     *
     * @return AbstractEntity Empty entity
     */
    abstract public function create();
}
