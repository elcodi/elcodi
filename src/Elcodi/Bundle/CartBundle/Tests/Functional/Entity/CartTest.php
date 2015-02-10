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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\CartBundle\Tests\Functional\Entity;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CartLineTest
 */
class CartTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiCartBundle',
        );
    }

    /**
     * Test cart dimensions
     */
    public function testDimensions()
    {
        $cart = $this->find('cart', 2);

        $this->assertEquals(25, $cart->getHeight());
        $this->assertEquals(30, $cart->getWidth());
        $this->assertEquals(35, $cart->getDepth());
        $this->assertEquals(600, $cart->getWeight());
    }
}
