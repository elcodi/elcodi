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

namespace Elcodi\Component\Attribute\Entity\Interfaces;

use Doctrine\Common\Collections\Collection;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface AttributeInterface.
 *
 * Attributes are a key-value structure used to describe
 * product features or options.
 */
interface AttributeInterface
    extends
    IdentifiableInterface,
    EnabledInterface,
    DateTimeInterface
{
    /**
     * Sets attribute name.
     *
     * @param string $name
     *
     * @return AttributeInterface
     */
    public function setName($name);

    /**
     * Return attribute name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets attribute values.
     *
     * @param Collection $values
     *
     * @return AttributeInterface
     */
    public function setValues(Collection $values);

    /**
     * Gets attribute values.
     *
     * @return Collection
     */
    public function getValues();

    /**
     * Adds a value to this attribute collection.
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function addValue(ValueInterface $value);

    /**
     * Removes a value from this attribute collection.
     *
     * @param ValueInterface $value
     *
     * @return AttributeInterface
     */
    public function removeValue(ValueInterface $value);
}
