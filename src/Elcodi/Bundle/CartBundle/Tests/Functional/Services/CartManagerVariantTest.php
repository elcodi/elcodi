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
use Elcodi\Component\Attribute\Entity\Interfaces\ValueInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class CartManagerVariantTest.
 *
 * This will test CartManager common methods using a Product with variants
 */
class CartManagerVariantTest extends AbstractCartManagerTest
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
     * Creates, flushes and returns a Purchasable.
     *
     * @return PurchasableInterface
     */
    protected function createPurchasable()
    {
        return $this->find('purchasable', 6);
    }

    /**
     * Testing that the same purchasable does not generate
     * two different CartLine.
     */
    public function testAddSameVariantTwice()
    {
        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable($this->cart, $this->purchasable, 1);

        $this
            ->get('elcodi.manager.cart')
            ->addPurchasable($this->cart, $this->purchasable, 2);

        $this->assertEquals(1, $this->cart->getCartLines()->count());
        $this->assertResults(3);
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
            [1, 100, 100],
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
            [1, -100, 100],
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
            [1, 1, 1],
            [1, 0, 0],
            [1, 2, 2],
            [1, -1, 0],
            [1, 10, 10],
            [1, 101, 100],
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
            [101, 100],
            [false, 0],
            [null, 0],
            [true, 0],
            ['true', 0],
            ['', 0],
            [[], 0],
        ];
    }

    /**
     * Adding an Option to a Variant if a parent Product is not set must throw
     * a LogicException.
     *
     * @expectedException \LogicException
     */
    public function testAddOptionToOrphanVariantThrowsLogicException()
    {
        /**
         * @var ValueInterface $variantOption
         */
        $variantOption = $this->find('attribute_value', 1);
        /**
         * @var VariantInterface $variant
         */
        $this
            ->getFactory('product_variant')
            ->create()
            ->addOption($variantOption);
    }
}
