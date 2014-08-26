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

namespace Elcodi\Component\Currency\Entity\Interfaces;

/**
 * Interface CurrencyInterface
 */
interface CurrencyInterface
{
    /**
     * Get currency iso
     *
     * @return string
     */
    public function getIso();

    /**
     * Set currency iso
     *
     * @param string $iso The currency iso
     *
     * @return CurrencyInterface self object
     */
    public function setIso($iso);

    /**
     * Get currency symbol
     *
     * @return string
     */
    public function getSymbol();

    /**
     * Set currency symbol
     *
     * @param string $symbol The currency symbol
     *
     * @return CurrencyInterface self object
     */
    public function setSymbol($symbol);

}
