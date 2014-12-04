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

namespace Elcodi\Component\Configuration\Entity;

use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * Class Parameter
 */
class Configuration implements ConfigurationInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var integer
     *
     * Entity id
     */
    protected $id;

    /**
     * @var string
     *
     * Configuration namespace
     */
    protected $namespace;

    /**
     * @var string
     *
     * Parameter name
     */
    protected $parameter;

    /**
     * @var string
     *
     * Configuration value
     */
    protected $value;

    /**
     * Set id
     *
     * @param int $id Entity Id
     *
     * @return $this self Object
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
     * Gets parameter name
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * Sets parameter name
     *
     * @param string $name
     *
     * @return $this self Object
     */
    public function setParameter($name)
    {
        $this->parameter = $name;

        return $this;
    }

    /**
     * Gets configuration value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets ocnfiguration value
     *
     * @param mixed $value
     *
     * @return $this self Object
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Gets configuration namespace
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Setc configuration namespace
     *
     * @param mixed $namespace
     *
     * @return $this self Object
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}
