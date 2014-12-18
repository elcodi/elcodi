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

namespace Elcodi\Component\Core\Factory\Traits;

/**
 * Trait EntityNamespaceTrait
 */
trait EntityNamespaceTrait
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
     * @return $this self Object
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
}
