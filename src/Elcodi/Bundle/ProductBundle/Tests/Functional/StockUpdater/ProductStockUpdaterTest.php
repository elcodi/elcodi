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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\StockUpdater;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class ProductStockUpdaterTest.
 */
class ProductStockUpdaterTest extends WebTestCase
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
     * Test update stock.
     */
    public function testUpdateStock()
    {
        $product = $this->find('product', 1);
        $this->get('elcodi.stock_updater.product')->updateStock(
            $product,
            2
        );
        $this->clear($product);
        $product = $this->find('product', 1);
        $this->assertEquals(
            8,
            $product->getStock()
        );
    }
}
