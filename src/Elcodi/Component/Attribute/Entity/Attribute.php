<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Attribute\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

/**
 * Class Attribute.
 */
class Attribute implements AttributeInterface
{
    use IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait;

    /**
     * @var string
     *
     * Attribute name
     */
    protected $name;

    /**
     * Values for this Attribute.
     *
     * @var Collection
     */
    protected $values;

    /**
     * Return attribute name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets attribute name.
     *
     * @param string $name
     *
     * @return AttributeInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets attribute values.
     *
     * @return Collection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Sets attribute values.
     *
     * @param Collection $values
     *
     * @return AttributeInterface
     */
    public function setValues(Collection $values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Adds a value to this attribute collection.
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function addValue(ValueInterface $value)
    {
        $this->values->add($value);

        return $this;
    }

    /**
     * Removes a value from this attribute collection.
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function removeValue(ValueInterface $value)
    {
        $this->values->removeElement($value);

        return $this;
    }

    /**
     * Returns the attribute name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
