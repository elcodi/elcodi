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

namespace Elcodi\CurrencyBundle\Tests\Functional\Repository;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CurrencyRepositoryTest
 */
class CurrencyRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.currency.repository.currency',
            'elcodi.repository.currency',
        ];
    }

    /**
     * Test currency repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.currency.repository.currency.class'),
            $this->get('elcodi.core.currency.repository.currency')
        );
    }

    /**
     * Test currency repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.currency.repository.currency.class'),
            $this->get('elcodi.repository.currency')
        );
    }
}
