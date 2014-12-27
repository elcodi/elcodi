<?php

/*
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

namespace Elcodi\Component\Currency\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Currency
 */
class Currency implements CurrencyInterface
{
    use
        IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait;

    /**
     * @var string
     *
     * The currency iso code
     */
    protected $iso;

    /**
     * @var string
     *
     * The currency symbol
     */
    protected $symbol;

    /**
     * Set iso
     *
     * @param string $iso Iso
     *
     * @return $this self Object
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Set symbol
     *
     * @param string $symbol Symbol
     *
     * @return $this self Object
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
