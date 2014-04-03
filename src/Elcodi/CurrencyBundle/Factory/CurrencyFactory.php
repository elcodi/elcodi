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
use Elcodi\CurrencyBundle\Entity\Currency;

/**
 * Class CurrencyFactory
 */
class CurrencyFactory extends AbstractFactory
{
    /**
     * Creates an instance of Currency entity
     *
     * @return Currency Empty entity
     */
    public function create()
    {
        /**
         * @var Currency $currency
         */
        $classNamespace = $this->getEntityNamespace();
        $currency = new $classNamespace();
        $currency->setCreatedAt(new \DateTime());

        return $currency;
    }
}
