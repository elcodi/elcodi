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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\StockValidator;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class VariantStockValidatorTest.
 */
class VariantStockValidatorTest extends WebTestCase
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
     * Test product validator.
     */
    public function testIsStockAvailable()
    {
        $variant = $this->find('product_variant', 6);
        $variantStockValidator = $this->get('elcodi.stock_validator.product_variant');
        $this->assertTrue(
            $variantStockValidator->isStockAvailable(
                $variant,
                1,
                true
            )
        );

        $this->assertEquals(
            100,
            $variantStockValidator->isStockAvailable(
                $variant,
                101,
                true
            )
        );

        $purchasableStockValidator = $this->get('elcodi.stock_validator.purchasable');

        $this->assertTrue(
            $purchasableStockValidator->isStockAvailable(
                $variant,
                1,
                true
            )
        );

        $this->assertEquals(
            100,
            $purchasableStockValidator->isStockAvailable(
                $variant,
                101,
                true
            )
        );
    }
}
