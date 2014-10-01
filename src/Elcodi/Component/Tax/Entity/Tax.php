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

namespace Elcodi\Component\Tax\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Tax\Entity\Interfaces\TaxInterface;

/**
 * Class Tax
 */
class Tax implements TaxInterface
{
    use EnabledTrait, DateTimeTrait

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     *
     * Tax name
     */
    protected $name;

    /**
     * @var string
     *
     * Tax description
     */
    protected $description;

    /**
     * @var float
     *
     * Tax percent value
     */
    protected $value;

    /**
     * Gets Tax name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets tax name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Tax description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets Tax description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Sets Tax value in percentage
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets Tax value in percentage
     *
     * @param float $value
     *
     * @return $this;
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
