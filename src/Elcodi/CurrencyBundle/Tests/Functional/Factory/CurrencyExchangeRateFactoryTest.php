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

namespace Elcodi\CurrencyBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class CurrencyExchangeRateFactoryTest
 */
class CurrencyExchangeRateFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.currency.factory.currency_exchange_rate';
    }

    /**
     * Test currency_exchange_rate factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.currency.entity.currency_exchange_rate.class'),
            $this->container->get('elcodi.core.currency.entity.currency_exchange_rate.instance')
        );
    }
}
