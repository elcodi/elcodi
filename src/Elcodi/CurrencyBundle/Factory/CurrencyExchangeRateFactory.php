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

namespace Elcodi\CurrencyBundle\Factory;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\CurrencyBundle\Entity\CurrencyExchangeRate;

/**
 * Class CurrencyExchangeRateFactory
 */
class CurrencyExchangeRateFactory extends AbstractFactory
{
    /**
     * Creates an instance of CurrencyExchangeRate entity
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
