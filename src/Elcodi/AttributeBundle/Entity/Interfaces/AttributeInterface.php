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

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Interfaces\DateTimeInterface;
use Elcodi\CoreBundle\Entity\Interfaces\EnabledInterface;

/**
 * Interface AttributeInterface
 *
 * Attributes are a key-value structure used to describe
 * product features or options.
 */
interface AttributeInterface extends EnabledInterface, DateTimeInterface
{
    /**
     * Sets attribute name
     *
     * @param string $name
     *
     * @return AttributeInterface
     */
    public function setName($name);

    /**
     * Return attribute name
     *
     * @return string
     */
    public function getName();

    /**
     * Sets attribute display name
     *
     * @param string $displayName
     *
     * @return AttributeInterface
     */
    public function setDisplayName($displayName);

    /**
     * Return attribute display name
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Sets attribute values
     *
     * @param Collection $values
     *
     * @return AttributeInterface
     */
    public function setValues(Collection $values);

    /**
     * Gets attribute values
     *
     * @return Collection
     */
    public function getValues();

    /**
     * Adds a value to this attribute collection
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function addValue(ValueInterface $value);

    /**
     * Removes a value to this attribute collection
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function removeValue(ValueInterface $value);
} 