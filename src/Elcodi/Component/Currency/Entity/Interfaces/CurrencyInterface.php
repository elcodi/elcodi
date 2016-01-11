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

namespace Elcodi\Component\Currency\Entity\Interfaces;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;

/**
 * Interface CurrencyInterface.
 */
interface CurrencyInterface
    extends
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Get currency iso.
     *
     * @return string
     */
    public function getIso();

    /**
     * Set currency iso.
     *
     * @param string $iso The currency iso
     *
     * @return $this Self object
     */
    public function setIso($iso);

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name);

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName();

    /**
     * Get currency symbol.
     *
     * @return string
     */
    public function getSymbol();

    /**
     * Set currency symbol.
     *
     * @param string $symbol The currency symbol
     *
     * @return $this Self object
     */
    public function setSymbol($symbol);
}
