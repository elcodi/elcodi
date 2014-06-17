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

namespace Elcodi\CurrencyBundle\Entity;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\DateTimeTrait;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * Currency
 */
class Currency extends AbstractEntity implements CurrencyInterface
{
    use DateTimeTrait, EnabledTrait;

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
     * @return Currency self Object
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
     * @return Currency self Object
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
