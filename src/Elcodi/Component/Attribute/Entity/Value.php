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

use Elcodi\Component\Attribute\Entity\Interfaces\AttributeInterface;
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;

/**
 * Class Value.
 */
class Value implements ValueInterface
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * Value content
     */
    protected $value;

    /**
     * @var AttributeInterface
     *
     * Attribute
     */
    protected $attribute;

    /**
     * Get Value.
     *
     * @return string Value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Value.
     *
     * @param string $value Value
     *
     * @return $this Self object
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get Attribute.
     *
     * @return AttributeInterface Attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Sets Attribute.
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this Self object
     */
    public function setAttribute(AttributeInterface $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * String representation of a value.
     *
     * @return string String representation
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
