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

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

/**
 * Class Parameter
 */
class Configuration extends AbstractEntity
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var integer
     *
     * Entity id
     */
    protected $id;

    protected $namespace;

    protected $parameter;

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
     * @return mixed
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * @param mixed $name
     *
     * @return $this self Object
     */
    public function setParameter($name)
    {
        $this->parameter = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
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
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
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