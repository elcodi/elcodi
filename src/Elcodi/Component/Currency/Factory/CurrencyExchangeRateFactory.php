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

namespace Elcodi\Component\Currency\Factory;

use Elcodi\Component\Core\Factory\Abstracts\AbstractFactory;
use Elcodi\Component\Currency\Entity\CurrencyExchangeRate;

/**
 * Class CurrencyExchangeRateFactory.
 */
class CurrencyExchangeRateFactory extends AbstractFactory
{
    /**
     * Creates an instance of CurrencyExchangeRate entity.
     *
     * @return CurrencyExchangeRate Empty entity
     */
    public function create()
    {
        /**
         * @var CurrencyExchangeRate $exchangeRate
         */
        $classNamespace = $this->getEntityNamespace();
        $exchangeRate = new $classNamespace();
        $exchangeRate->setExchangeRate(0.0);

        return $exchangeRate;
    }
}
