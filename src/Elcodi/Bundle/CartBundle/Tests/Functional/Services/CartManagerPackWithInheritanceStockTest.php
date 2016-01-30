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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Services;

use Elcodi\Bundle\CartBundle\Tests\Functional\Services\Abstracts\AbstractCartManagerTest;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class CartManagerVariantTest.
 *
 * This will test CartManager common methods using a Pack with inheritance stock
 */
class CartManagerPackWithInheritanceStockTest extends AbstractCartManagerTest
{
    /**
     * Load fixtures of these bundles.
     *
     * @return array Bundles name where fixtures should be found
     */
    protected static function loadFixturesBundles()
    {
        return [
            'ElcodiCartBundle',
            'ElcodiProductBundle',
        ];
    }

    /**
     * Creates, flushes and returns a Purchasable.
     *
     * @return PurchasableInterface
     */
    protected function createPurchasable()
    {
        return $this->find('purchasable_pack', 10);
    }

    /**
     * Data for testIncreaseCartLineQuantity.
     */
    public function dataIncreaseCartLineQuantity()
    {
        return [
            [0, 1, 0],
            [1, 1, 2],
            [0, 0, 0],
            [1, -1, 0],
            [1, -2, 0],
            [1, 20, 5],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testDecreaseCartLineQuantity.
     */
    public function dataDecreaseCartLineQuantity()
    {
        return [
            [1, 1, 0],
            [1, 0, 1],
            [1, 2, 0],
            [1, -1, 2],
            [1, -20, 5],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testSetCartLineQuantity.
     */
    public function dataSetCartLineQuantity()
    {
        return [
            [1, 21, 5],
            [1, 1, 1],
            [1, 0, 0],
            [1, 2, 2],
            [1, -1, 0],
            [1, 5, 5],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testAddPurchasable.
     */
    public function dataAddPurchasable()
    {
        return [
            [1, 1],
            [0, 0],
            [21, 5],
            [false, 0],
            [null, 0],
            [true, 0],
            ['true', 0],
            ['', 0],
            [[], 0],
        ];
    }
}
