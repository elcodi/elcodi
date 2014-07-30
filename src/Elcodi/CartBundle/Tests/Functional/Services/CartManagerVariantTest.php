<?php

/**
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
 */

namespace Elcodi\CartBundle\Tests\Functional\Services;

use Elcodi\AttributeBundle\Entity\Interfaces\ValueInterface;
use Elcodi\CartBundle\Tests\Functional\Services\Abstracts\AbstractCartManagerTest;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Elcodi\ProductBundle\Entity\Interfaces\PurchasableInterface;
use Elcodi\ProductBundle\Entity\Interfaces\VariantInterface;

/**
 * Class CartManagerVariantTest
 *
 * This will test CartManager common methods using a Product with variants
 */
class CartManagerVariantTest extends AbstractCartManagerTest
{
    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiCurrencyBundle',
            'ElcodiAttributeBundle'
        ];
    }

    /**
     * @var VariantInterface
     */
    protected $variant;

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
            ->container
            ->get('elcodi.repository.currency')
            ->findOneBy([
                'iso' => 'USD',
            ]);

        /**
         * @var ValueInterface $variantOption
         */
        $variantOption = $this
            ->container
            ->get('elcodi.repository.value')
            ->find(1);

        /**
         * @var ProductInterface $product
         */
        $product = $this
            ->container
            ->get('elcodi.factory.product')
            ->create()
            ->setPrice(Money::create(1000, $currency))
            ->setName('abc')
            ->setSlug('abc')
            ->setEnabled(true)
            ->setStock(10);

        /**
         * @var VariantInterface $variant
         */
        $variant = $this
            ->container
            ->get('elcodi.factory.variant')
            ->create()
            ->setProduct($product)
            ->setPrice(Money::create(1200, $currency))
            ->addOption($variantOption)
            ->setEnabled(true)
            ->setStock(20);

        $product->setPrincipalVariant($variant);

        $this
            ->getManager('elcodi.core.product.entity.product.class')
            ->persist($product);
        $this
            ->getManager('elcodi.core.product.entity.variant.class')
            ->persist($variant);

        $this
            ->getManager('elcodi.core.product.entity.product.class')
            ->flush();
        $this
            ->getManager('elcodi.core.product.entity.variant.class')
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
            $this->container->getParameter('elcodi.core.product.entity.variant.class'),
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
            ->container
            ->get('elcodi.cart_manager')
            ->addProduct($this->cart, $this->purchasable, 1);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addProduct($this->cart, $this->purchasable, 2);

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
        $variantOption = $this
            ->container
            ->get('elcodi.repository.value')
            ->find(1);
        /**
         * @var VariantInterface $variant
         */
        $this
            ->container
            ->get('elcodi.factory.variant')
            ->create()
            ->addOption($variantOption);
    }

    /**
     * A product vith variant cannot be added to the cart with
     * CartManager::addProduct()
     */
    public function testCannotAddParentProductIfHasVariants()
    {
        $this->markTestSkipped();
    }
}
