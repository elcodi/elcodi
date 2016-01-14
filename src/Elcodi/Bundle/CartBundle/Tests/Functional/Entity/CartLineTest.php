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

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CartTest.
 */
class CartLineTest extends WebTestCase
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
        ];
    }

    /**
     * Test cart dimensions.
     */
    public function testDimensions()
    {
        $cart = $this->find('cart_line', 1);

        $this->assertEquals(10, $cart->getHeight());
        $this->assertEquals(15, $cart->getWidth());
        $this->assertEquals(20, $cart->getDepth());
        $this->assertEquals(200, $cart->getWeight());
    }
}
