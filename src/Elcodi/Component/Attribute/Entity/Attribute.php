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

namespace Elcodi\Component\Attribute\Entity;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;

class Attribute extends AbstractEntity implements AttributeInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Attribute name
     */
    protected $name;

    /**
     * Attribute display value
     *
     * @var string
     */
    protected $displayName;

    /**
     * Values for this Attribute
     *
     * @var Collection
     */
    protected $values;

    /**
     * Return attribute name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets attribute name
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
     * Return attribute display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Sets attribute display name
     *
     * @param string $displayName
     *
     * @return AttributeInterface
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Gets attribute values
     *
     * @return Collection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Sets attribute values
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
     * Adds a value to this attribute collection
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
     * Removes a value to this attribute collection
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
     * Returns the attribute name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

}
