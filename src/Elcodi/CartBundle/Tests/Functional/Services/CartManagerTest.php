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

use Doctrine\ORM\UnitOfWork;

use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Entity\Interfaces\CartLineInterface;
use Elcodi\CoreBundle\Tests\Functional\WebTestCase;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Entity\Money;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;

/**
 * Tests CartManager class
 */
class CartManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.cart.service.cart_manager',
            'elcodi.cart_manager',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return [
            'ElcodiCurrencyBundle',
        ];
    }

    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var CartLineInterface
     *
     * Cartline
     */
    protected $cartLine;

    /**
     * @var ProductInterface
     *
     * Product
     */
    protected $product;

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->cart = $this
            ->container
            ->get('elcodi.factory.cart')
            ->create();

        /**
         * @var CurrencyInterface $currency
         */
        $currency = $this
            ->getRepository('elcodi.core.currency.entity.currency.class')
            ->findOneBy([
                'iso' => 'USD',
            ]);

        $this->product = $this
            ->container
            ->get('elcodi.factory.product')
            ->create()
            ->setPrice(Money::create(1000, $currency))
            ->setName('abc')
            ->setSlug('abc')
            ->setEnabled(true)
            ->setStock(10);

        $this
            ->getManager('elcodi.core.product.entity.product.class')
            ->persist($this->product);

        $this
            ->getManager('elcodi.core.product.entity.product.class')
            ->flush();

        $this->cartLine = $this
            ->container
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setProduct($this->product)
            ->setProductAmount($this->product->getPrice())
            ->setAmount($this->product->getPrice())
            ->setQuantity(1);

        $this
            ->container
            ->get('elcodi.cart_event_dispatcher')
            ->dispatchCartLoadEvents($this->cart);
    }

    /**
     * Test add line
     *
     * @group cart
     */
    public function testAddLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine);

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getAmount()
        );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getProduct()->getPrice()
        );

        $this->assertNotNull($this->cart->getId());
        $this->assertNotNull($this->cartLine->getId());

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getManager('elcodi.core.cart.entity.cart.class')
                ->getUnitOfWork()
                ->getEntityState($this->cart)
        );

        $this->assertEquals(
            UnitOfWork::STATE_MANAGED,
            $this
                ->getManager('elcodi.core.cart.entity.cart_line.class')
                ->getUnitOfWork()
                ->getEntityState($this->cartLine)
        );
    }

    /**
     * Test remove line
     *
     * @group cart
     */
    public function testRemoveLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->removeLine($this->cart, $this->cartLine);

        $this->assertEmpty($this->cart->getCartLines());
        $this->assertNotNull($this->cart->getId());

        $this->assertEquals(
            UnitOfWork::STATE_NEW,
            $this->container
                ->get('elcodi.object_manager.cart_line')
                ->getUnitOfWork()
                ->getEntityState($this->cartLine)
        );
    }

    /**
     * Test empty lines
     *
     * @group cart
     */
    public function testEmptyLines()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->emptyLines($this->cart);

        $this->assertEmpty($this->cart->getCartLines());
        $this->assertNotNull($this->cart->getId());

        $this->assertEquals(
            UnitOfWork::STATE_NEW,
            $this->container
                ->get('elcodi.object_manager.cart_line')
                ->getUnitOfWork()
                ->getEntityState($this->cartLine)
        );
    }

    /**
     * Test edit cart line
     *
     * @group cart
     */
    public function testEditCartLine()
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->editCartLine($this->cartLine, $this->product, 2);

        $this->assertSame(
            $this->cartLine->getProduct(),
            $this->product
        );

        $this->assertEquals(
            $this->cart->getAmount(),
            $this->cart->getCartLines()->first()->getAmount()
        );

        $this->assertTrue(
            $this
                ->cart
                ->getAmount()
                ->equals($this
                    ->cart
                    ->getCartLines()
                    ->first()
                    ->getProduct()
                    ->getPrice()
                    ->multiply(2)
                )
        );
    }

    /**
     * Test increase cartline quantity
     *
     * @dataProvider dataIncreaseCartLineQuantity
     * @group        cart
     */
    public function testIncreaseCartLineQuantity(
        $quantityStart,
        $quantityAdded,
        $quantityEnd
    )
    {
        $this->cartLine = $this
            ->container
            ->get('elcodi.factory.cart_line')
            ->create()
            ->setProduct($this->product)
            ->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->increaseCartLineQuantity($this->cartLine, $quantityAdded);

        $this->assertResults($quantityEnd);
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
            [1, 10, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Test decrease cartline quantity
     *
     * @dataProvider dataDecreaseCartLineQuantity
     * @group        cart
     */
    public function testDecreaseCartLineQuantity(
        $quantityStart,
        $quantityRemoved,
        $quantityEnd
    )
    {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->decreaseCartLineQuantity($this->cartLine, $quantityRemoved);

        $this->assertResults($quantityEnd);
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
            [1, -10, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Test set cartline quantity
     *
     * @dataProvider dataSetCartLineQuantity
     * @group        cart
     */
    public function testSetCartLineQuantity(
        $quantityStart,
        $quantitySetted,
        $quantityEnd
    )
    {
        $this->cartLine->setQuantity($quantityStart);

        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addLine($this->cart, $this->cartLine)
            ->setCartLineQuantity($this->cartLine, $quantitySetted);

        $this->assertResults($quantityEnd);
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
            [1, 11, 10],
            [1, false, 1],
            [1, null, 1],
            [1, true, 1],
            [1, 'true', 1],
            [1, '', 1],
            [1, [], 1],
        ];
    }

    /**
     * Test add product
     *
     * @dataProvider dataAddProduct
     * @group        cart
     */
    public function testAddProduct(
        $quantitySet,
        $quantityEnd
    )
    {
        $this
            ->container
            ->get('elcodi.cart_manager')
            ->addProduct($this->cart, $this->product, $quantitySet);

        $this->assertResults($quantityEnd);
    }

    /**
     * Data for testAddProduct
     */
    public function dataAddProduct()
    {
        return [
            [1, 1],
            [0, 0],
            [11, 10],
            [false, 0],
            [null, 0],
            [true, 0],
            ['true', 0],
            ['', 0],
            [[], 0],
        ];
    }

    /**
     * Test result
     */
    public function assertResults($quantity)
    {
        if ($quantity > 0) {

            $cartLine = $this->cart->getCartLines()->first();

            $this->assertEquals(
                $this->cart->getAmount(),
                $cartLine->getAmount()
            );

            $this->assertEquals(
                $this->cart->getAmount()->getAmount(),
                $cartLine->getProduct()->getPrice()->getAmount() * $quantity
            );

            $this->assertNotNull($cartLine->getId());
            $this->assertNotNull($this->cart->getId());

            $this->assertEquals(
                UnitOfWork::STATE_MANAGED,
                $this
                    ->getManager('elcodi.core.cart.entity.cart.class')
                    ->getUnitOfWork()
                    ->getEntityState($this->cart)
            );

        } else {
            $this->assertEmpty($this->cart->getCartLines());
            $this->assertEquals(0, $this->cart->getAmount()->getAmount());

            $this->assertEquals(
                UnitOfWork::STATE_NEW,
                $this
                    ->getManager('elcodi.core.cart.entity.cart_line.class')
                    ->getUnitOfWork()
                    ->getEntityState($this->cartLine)
            );
        }
    }
}
