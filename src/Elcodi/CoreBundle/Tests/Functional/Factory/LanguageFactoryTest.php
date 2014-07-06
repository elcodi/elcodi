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

namespace Elcodi\CoreBundle\Tests\Functional\Factory;

use Elcodi\CoreBundle\Tests\Functional\WebTestCase;

/**
 * Class LanguageFactoryTest
 */
class LanguageFactoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.core.factory.language',
            'elcodi.factory.language',
        ];
    }

    /**
     * Test language factory provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.core.entity.language.class'),
            $this->container->get('elcodi.core.core.entity.language.instance')
        );
    }

    /**
     * Test language factory provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->container->getParameter('elcodi.core.core.entity.language.class'),
            $this->container->get('elcodi.entity.language.instance')
        );
    }
}
