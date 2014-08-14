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

namespace Elcodi\LanguageBundle\Tests\Functional\Repository;

use Elcodi\TestCommonBundle\Functional\WebTestCase;

/**
 * Class LanguageRepositoryTest
 */
class LanguageRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.language.repository.language',
            'elcodi.repository.language',
        ];
    }

    /**
     * Test language repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.language.repository.language.class'),
            $this->get('elcodi.core.language.repository.language')
        );
    }

    /**
     * Test language repository provider alias
     */
    public function testFactoryProviderAlias()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.core.language.repository.language.class'),
            $this->get('elcodi.repository.language')
        );
    }
}
