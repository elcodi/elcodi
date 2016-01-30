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

namespace Elcodi\Component\Currency\Entity;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class Currency.
 */
class Currency implements CurrencyInterface
{
    use DateTimeTrait,
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
     * The currency name
     */
    protected $name;

    /**
     * @var string
     *
     * The currency symbol
     */
    protected $symbol;

    /**
     * Set iso.
     *
     * @param string $iso Iso
     *
     * @return $this Self object
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso.
     *
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * Sets Name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set symbol.
     *
     * @param string $symbol Symbol
     *
     * @return $this Self object
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol.
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }
}
