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
 * @author Elcodi Team <tech@elcodi.com>
 */
 
namespace Elcodi\Bundle\CurrencyBundle\Tests\Functional\Adapter\CurrencyExchangeRatesProvider;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class YahooFinanceProviderAdapterTest
 */
class YahooFinanceProviderAdapterTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.currency_exchange_rate_adapter.yahoo_finances',
        ];
    }
}
