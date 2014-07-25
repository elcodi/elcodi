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

namespace Elcodi\AttributeBundle\Entity\Interfaces;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

interface ValueInterface extends EnabledInterface, DateTimeInterface
{
    /**
     * Sets this value name
     *
     * @param string $name
     *
     * @return ValueInterface
     */
    public function setName($name);

    /**
     * Returns this value name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets this value display name
     *
     * @param string $displayName
     *
     * @return ValueInterface
     */
    public function setDisplayName($displayName);

    /**
     * Return this value display name
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Sets an Attribute that owns this Value
     *
     * @param AttributeInterface $attribute
     *
     * @return ValueInterface
     */
    public function setAttribute(AttributeInterface $attribute);

    /**
     * Gets the attribute that owns this Value
     *
     * @return AttributeInterface
     */
    public function getAttribute();
}
