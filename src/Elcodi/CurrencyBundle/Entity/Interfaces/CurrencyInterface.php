<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Entity\Interfaces;

/**
 * Interface CurrencyInterface
 *
 * @package Elcodi\CurrencyBundle\Entity\Interfaces
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
