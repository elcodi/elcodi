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

namespace Elcodi\AttributeBundle\Entity;

use Elcodi\AttributeBundle\Entity\Interfaces\AttributeInterface;
use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

class Value extends AbstractEntity implements ValueInterface
{
    use DateTimeTrait, EnabledTrait;

    /**
     * @var string
     *
     * Value name
     */
    protected $name;

    /**
     * @var string
     *
     * Value display name
     */
    protected $displayName;

    /**
     * @var AttributeInterface
     *
     * The Attribute who owns this value
     */
    protected $attribute;

    /**
     * Sets this value name
     *
     * @param string $name
     *
     * @return ValueInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns this value name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets this value display name
     *
     * @param string $displayName
     *
     * @return ValueInterface
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Return value display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Sets an Attribute that owns this Value
     *
     * @param AttributeInterface $attribute
     *
     * @return ValueInterface
     */
    public function setAttribute(AttributeInterface $attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Gets the attribute that owns this Value
     *
     * @return AttributeInterface
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

}