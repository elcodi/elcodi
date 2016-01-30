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
 * Class PackStockValidatorTest.
 */
class PackStockValidatorTest extends WebTestCase
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
     * Test product validator without stock inheritance.
     */
    public function testIsStockAvailableNonInheritance()
    {
        $pack = $this->find('purchasable_pack', 9);
        $packStockValidator = $this->get('elcodi.stock_validator.purchasable_pack');
        $this->assertTrue(
            $packStockValidator->isStockAvailable(
                $pack,
                1,
                true
            )
        );

        $this->assertEquals(
            10,
            $packStockValidator->isStockAvailable(
                $pack,
                11,
                true
            )
        );

        $purchasableStockValidator = $this->get('elcodi.stock_validator.purchasable');

        $this->assertTrue(
            $purchasableStockValidator->isStockAvailable(
                $pack,
                1,
                true
            )
        );

        $this->assertEquals(
            10,
            $purchasableStockValidator->isStockAvailable(
                $pack,
                11,
                true
            )
        );
    }

    /**
     * Test product validator with stock inheritance.
     */
    public function testIsStockAvailableInheritance()
    {
        $pack = $this->find('purchasable_pack', 10);
        $packStockValidator = $this->get('elcodi.stock_validator.purchasable_pack');
        $this->assertTrue(
            $packStockValidator->isStockAvailable(
                $pack,
                1,
                true
            )
        );

        $this->assertEquals(
            5,
            $packStockValidator->isStockAvailable(
                $pack,
                10,
                true
            )
        );
    }
}
