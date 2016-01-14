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

use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface ValueInterface.
 */
interface ValueInterface extends IdentifiableInterface
{
    /**
     * Get Value.
     *
     * @return string Value
     */
    public function getValue();

    /**
     * Sets Value.
     *
     * @param string $value Value
     *
     * @return $this Self object
     */
    public function setValue($value);

    /**
     * Get Attribute.
     *
     * @return AttributeInterface Attribute
     */
    public function getAttribute();

    /**
     * Sets Attribute.
     *
     * @param AttributeInterface $attribute Attribute
     *
     * @return $this Self object
     */
    public function setAttribute(AttributeInterface $attribute);
}
