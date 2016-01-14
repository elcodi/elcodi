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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\NameResolver;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ProductNameResolverTest.
 */
class ProductNameResolverTest extends WebTestCase
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiProductBundle',
        ];
    }

    /**
     * Test resolve name.
     */
    public function testResolveName()
    {
        $product = $this->find('product', 2);
        $this->assertEquals(
            'product-reduced',
            $this
                ->get('elcodi.name_resolver.product')
                ->resolveName($product)
        );
        $this->assertEquals(
            'product-reduced',
            $this
                ->get('elcodi.name_resolver.purchasable')
                ->resolveName($product)
        );
    }
}
