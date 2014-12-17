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

namespace Elcodi\Component\Configuration\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface ConfigurationInterface
 */
interface ConfigurationInterface extends DateTimeInterface, EnabledInterface
{
    /**
     * Gets parameter name
     *
     * @return mixed
     */
    public function getParameter();

    /**
     * Sets parameter name
     *
     * @param mixed $name
     *
     * @return $this self Object
     */
    public function setParameter($name);

    /**
     * Gets configuration value
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Sets configuration value
     *
     * @param mixed $value
     *
     * @return $this self Object
     */
    public function setValue($value);

    /**
     * Gets configuration namespace
     *
     * @return mixed
     */
    public function getNamespace();

    /**
     * Sets configuration namespace
     *
     * @param mixed $namespace
     *
     * @return $this self Object
     */
    public function setNamespace($namespace);
}
