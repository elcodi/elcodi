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

namespace Elcodi\RuleBundle\Tests\Functional\Factory;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ExpressionFactoryTest
 */
class ExpressionFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.rule.factory.expression',
            'elcodi.factory.expression',
        ];
    }

    /**
     * Test expression factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.rule.entity.expression.class'),
            $this->get('elcodi.core.rule.entity.expression.instance')
        );
    }

    /**
     * Test expression factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.rule.entity.expression.class'),
            $this->get('elcodi.entity.expression.instance')
        );
    }
}
