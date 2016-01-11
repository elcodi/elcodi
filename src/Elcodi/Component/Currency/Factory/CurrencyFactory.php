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
use Elcodi\Component\Currency\Entity\Currency;

/**
 * Class CurrencyFactory.
 */
class CurrencyFactory extends AbstractFactory
{
    /**
     * Creates an instance of Currency entity.
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
        $currency
            ->setEnabled(true)
            ->setCreatedAt($this->now());

        return $currency;
    }
}
