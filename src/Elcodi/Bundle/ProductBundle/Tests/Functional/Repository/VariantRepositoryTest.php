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
 */

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Repository;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class VariantRepositoryTest
 */
class VariantRepositoryTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.repository.product_variant',
        ];
    }

    /**
     * Test variant repository provider
     */
    public function testFactoryProvider()
    {
        $this->assertInstanceOf(
            'Doctrine\Common\Persistence\ObjectRepository',
            $this->get('elcodi.repository.product_variant')
        );
    }
}
