<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;
use Elcodi\Component\Product\Entity\Interfaces\VariantInterface;

/**
 * Class CartManagerVariantTest
 *
 * This will test CartManager common methods using a Product with variants
 */
class CartManagerVariantTest extends AbstractCartManagerTest
{
    /**
     * @var VariantInterface
     *
     * Variant
     */
    protected $variant;

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiCurrencyBundle',
            'ElcodiAttributeBundle',
            'ElcodiStoreBundle',
        ];
    }

    /**
     * Creates, flushes and returns a Purchasable
     *
     * @return PurchasableInterface
     */
    protected function createPurchasable()
    {
        /**
         * @var CurrencyInterface $currency
         */
        $currency = $this
            ->getRepository('currency')
            ->findOneBy([
                'iso' => 'USD',
            ]);

        /**
         * @var ValueInterface $variantOption
         */
        $variantOption = $this->find('attribute_value', 1);

        /**
         * @var ProductInterface $product
         */
        $product = $this
            ->getFactory('product')
            ->create()
            ->setPrice(Money::create(1000, $currency))
            ->setName('abc')
            ->setSlug('abc')
            ->setEnabled(true)
            ->setWidth(10)
            ->setHeight(10)
            ->setDepth(10)
            ->setWeight(10)
            ->setStock(10);

        /**
         * @var VariantInterface $variant
         */
        $variant = $this
            ->getFactory('product_variant')
            ->create()
            ->setProduct($product)
            ->setPrice(Money::create(1200, $currency))
            ->addOption($variantOption)
            ->setWidth(10)
            ->setHeight(10)
            ->setDepth(10)
            ->setWeight(10)
            ->setEnabled(true)
            ->setStock(20);

        $product->setPrincipalVariant($variant);

        $this
            ->getObjectManager('product')
            ->persist($product);
        $this
            ->getObjectManager('product_variant')
            ->persist($variant);

        $this
            ->getObjectManager('product')
            ->flush();
        $this
            ->getObjectManager('product_variant')
            ->flush();

        $this->variant = $variant;

        return $variant;
    }

    /**
     * Testing that a purchasable is a Variant
     */
    public function testPurchasableIsVariant()
    {
        $this->assertInstanceOf(
            $this->getParameter('elcodi.entity.product_variant.class'),
            $this->purchasable
        );
    }

    /**
     * Testing that the same purchasable does not generate
     * two different CartLine
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
     * Data for testIncreaseCartLineQuantity
     */
    public function dataIncreaseCartLineQuantity()
    {
        return [
            [0, 1, 0],
            [1, 1, 2],
            [0, 0, 0],
            [1, -1, 0],
            [1, -2, 0],
            [1, 20, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testDecreaseCartLineQuantity
     */
    public function dataDecreaseCartLineQuantity()
    {
        return [
            [1, 1, 0],
            [1, 0, 1],
            [1, 2, 0],
            [1, -1, 2],
            [1, -20, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testSetCartLineQuantity
     */
    public function dataSetCartLineQuantity()
    {
        return [
            [1, 1, 1],
            [1, 0, 0],
            [1, 2, 2],
            [1, -1, 0],
            [1, 10, 10],
            [1, 21, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Data for testAddProduct
     */
    public function dataAddProduct()
    {
        return [
            [1, 1],
            [0, 0],
            [21, 20],
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
     * a LogicException
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
