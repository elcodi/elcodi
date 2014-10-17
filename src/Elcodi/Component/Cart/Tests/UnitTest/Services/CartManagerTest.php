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

namespace Elcodi\Component\Cart\Tests\UnitTest\Services;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Cart\Entity\CartLine;
use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher;
use Elcodi\Component\Cart\EventDispatcher\CartLineEventDispatcher;
use Elcodi\Component\Cart\Factory\CartFactory;
use Elcodi\Component\Cart\Factory\CartLineFactory;
use Elcodi\Component\Cart\Services\CartManager;
use Elcodi\Component\Cart\Wrapper\CartWrapper;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class CartManagerTest
 */
class CartManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CartManager
     *
     * CartManager
     */
    protected $cartManager;

    /**
     * @var CartFactory
     *
     * Cart factory
     */
    protected $cartFactory;

    /**
     * @var CartLineFactory
     *
     * Cart factory
     */
    protected $cartLineFactory;

    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * Set up
     */
    public function setUp()
    {
        /**
         * @var CartEventDispatcher $cartEventDispatcher
         * @var CartLineEventDispatcher $cartLineEventDispatcher
         * @var CartFactory         $cartFactory
         * @var CartLineFactory     $cartLineFactory
         * @var CartWrapper         $cartWrapper
         */
        $cartEventDispatcher = $this->getMock('Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher', [], [], '', false);
        $cartLineEventDispatcher = $this->getMock('Elcodi\Component\Cart\EventDispatcher\CartLineEventDispatcher', [], [], '', false);
        $cartFactory = $this->getMock('Elcodi\Component\Cart\Factory\CartFactory', ['create']);
        $cartLineFactory = $this->getMock('Elcodi\Component\Cart\Factory\CartLineFactory', ['create']);

        $this->cartManager = new CartManager(
            $cartEventDispatcher,
            $cartLineEventDispatcher,
            $cartFactory,
            $cartLineFactory
        );

        $this->cartFactory = $cartFactory;
        $this->cartLineFactory = $cartLineFactory;
    }

    /**
     * addLine with empty cart
     *
     * @group cart
     */
    public function testAddLineInEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $this->assertEquals(0, $cart->getTotalItemNumber());
        $purchaseable = $this->getMock(
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface'
        );

        $this->cartLineFactory
            ->expects($this->exactly(1))
            ->method('create')
            ->will($this->returnValue(new CartLine()));

        $this->cartManager->addProduct($cart, $purchaseable, 1);

        $this->assertCount(1, $cart->getCartLines());
        $this->assertEquals(1, $cart->getTotalItemNumber());
    }

    /**
     * addLine twice with empty cart
     *
     * @group cart
     */
    public function testAddLineTwiceInEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $purchaseable = $this->getMock('Elcodi\Component\Product\Entity\Product', ['getId']);

        $this->cartLineFactory
            ->expects($this->exactly(1))
            ->method('create')
            ->will($this->returnValue(new CartLine()));

        $purchaseable
            ->expects($this->any())
            ->method('getId')
            ->will($this->returnValue(1));

        $this
            ->cartManager
            ->addProduct($cart, $purchaseable, 1)
            ->addProduct($cart, $purchaseable, 1);

        $this->assertCount(1, $cart->getCartLines());
    }

    /**
     * removeLine with a non empty cart
     *
     * @group cart
     */
    public function testRemoveLineFromNonEmptyCart()
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));
        $cartLine->setCart($cart);

        $this->assertCount(1, $cart->getCartLines());
        $this->cartManager->removeLine($cart, $cartLine);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * removeLine with an empty cart
     *
     * @group cart
     */
    public function testRemoveLineFromEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $cartLine = new CartLine();
        $cartLine->setCart($cart);

        $this->assertCount(0, $cart->getCartLines());
        $this->cartManager->removeLine($cart, $cartLine);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * emptyLines with a non empty cart
     *
     * @group cart
     */
    public function testEmptyLinesFromNonEmptyCart()
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));
        $cartLine->setCart($cart);

        $this->assertCount(1, $cart->getCartLines());
        $this->cartManager->emptyLines($cart);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * emptyLines with an empty cart
     *
     * @group cart
     */
    public function testEmptyLinesFromEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());

        $this->assertCount(0, $cart->getCartLines());
        $this->cartManager->emptyLines($cart);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * editCartLine test
     *
     * @dataProvider dataEditCartLine
     * @group cart
     */
    public function testEditCartLine($initialQuantity, $newQuantity, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);

        /**
         * @var ProductInterface $product
         */
        $product = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $cartLine->setQuantity($initialQuantity);
        $cartLine->setProduct($product);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->editCartLine($cartLine, $product, $newQuantity);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataEditCartLine()
    {
        return array(
            array(null, null, null),
            array(1, null, 1),
            array(1, false, 1),
            array(1, 1, 1),
            array(null, 1, 1),
            array(1, 2, 2),
        );
    }

    /**
     * increaseCartLineQuantity with empty Cart
     *
     * @dataProvider dataIncreaseCartLineQuantity
     * @group cart
     */
    public function testIncreaseCartLineQuantity($initialQuantity, $quantityToIncrease, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->increaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataIncreaseCartLineQuantity()
    {
        return array(
            array(1, null, 1),
            array(1, false, 1),
            array(1, 1, 2),
            array(null, 1, 1),
        );
    }

    /**
     * increaseCartLineQuantity with empty Cart
     *
     * @dataProvider dataDecreaseCartLineQuantityNotRemove
     * @group cart
     */
    public function testDecreaseCartLineQuantityNotRemove($initialQuantity, $quantityToIncrease, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->decreaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataDecreaseCartLineQuantityNotRemove()
    {
        return array(
            array(2, null, 2),
            array(2, false, 2),
            array(3, 1, 2),
        );
    }

    /**
     * increaseCartLineQuantity with empty Cart
     *
     * @dataProvider dataDecreaseCartLineQuantityRemove
     * @group cart
     */
    public function testDecreaseCartLineQuantityRemove($initialQuantity, $quantityToIncrease)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->decreaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEmpty($cart->getCartLines());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataDecreaseCartLineQuantityRemove()
    {
        return array(
            array(1, 1),
            array(1, 2),
        );
    }

    /**
     * addProduct
     *
     * @dataProvider dataAddProduct
     * @group cart
     */
    public function testAddProduct($quantity, $productCreated, $quantityExpected)
    {
        $cartLine = new CartLine();
        $this->cartLineFactory
            ->expects($this->exactly(intval($productCreated)))
            ->method('create')
            ->will($this->returnValue($cartLine));

        /**
         * @var ProductInterface $product
         */
        $product = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\ProductInterface');
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());

        $this->cartManager->addProduct($cart, $product, $quantity);

        if ($productCreated) {

            $createdLine = $cart->getCartLines()->first();
            $createdProduct = $createdLine->getProduct();

            $this->assertCount(1, $cart->getCartLines());
            $this->assertInstanceOf('Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface', $createdLine);
            $this->assertSame($createdProduct, $product);
            $this->assertEquals($createdLine->getQuantity(), $quantityExpected);
        } else {

            $this->assertCount(0, $cart->getCartLines());
        }
    }

    /**
     * Data provider for testAddProduct
     */
    public function dataAddProduct()
    {
        return [
            [1, true, 1],
            [2, true, 2],
            [0, false, 0],
            [null, false, 0],
            [false, false, 0],
            [true, false, 0],
            [[], false, 0],
            ['false', false, 0],
            [-1, false, 0],
        ];
    }
}
