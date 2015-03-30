<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Configuration\Entity;

use Elcodi\Component\Configuration\Entity\Interfaces\ConfigurationInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;

/**
 * Class Parameter
 */
class Configuration implements ConfigurationInterface
{
    use DateTimeTrait;

    /**
     * @var string
     *
     * Namespace
     */
    protected $namespace;

    /**
     * @var string
     *
     * Key
     */
    protected $key;

    /**
     * @var string
     *
     * Name
     */
    protected $name;

    /**
     * @var string
     *
     * Type
     */
    protected $type;

    /**
     * @var string
     *
     * Value
     */
    protected $value;

    /**
     * Get Key
     *
     * @return string Key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Sets Key
     *
     * @param string $key Key
     *
     * @return $this Self object
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Namespace
     *
     * @return string Namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Sets Namespace
     *
     * @param string $namespace Namespace
     *
     * @return $this Self object
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get Type
     *
     * @return string Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets Type
     *
     * @param string $type Type
     *
     * @return $this Self object
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get Value
     *
     * @return mixed Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Value
     *
     * @param mixed $value Value
     *
     * @return $this Self object
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
