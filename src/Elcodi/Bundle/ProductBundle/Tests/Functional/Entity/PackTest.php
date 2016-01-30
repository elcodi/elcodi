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

namespace Elcodi\Bundle\ProductBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class PackTest.
 */
class PackTest extends WebTestCase
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
     * Test get stock with specific stock.
     */
    public function testGetStockSpecificStock()
    {
        $this->assertEquals(10, $this
            ->find('purchasable_pack', 9)
            ->getStock()
        );
    }

    /**
     * Test get stock with inherit stock.
     */
    public function testGetStockInheritStock()
    {
        $this->assertEquals(5, $this
            ->find('purchasable_pack', 10)
            ->getStock()
        );
    }
}
