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

namespace Elcodi\Component\Tax\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface TaxInterface.
 */
interface TaxInterface extends IdentifiableInterface, EnabledInterface
{
    /**
     * Gets Tax name.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets tax name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * Get Tax description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets Tax description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * Sets Tax value in percentage.
     *
     * @return float
     */
    public function getValue();

    /**
     * Gets Tax value in percentage.
     *
     * @param float $value
     *
     * @return $this
     */
    public function setValue($value);
}
