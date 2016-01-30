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
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface;

/**
 * Class CartManagerTest.
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
     * Set up.
     */
    public function setUp()
    {
        /**
         * @var CartEventDispatcher     $cartEventDispatcher
         * @var CartLineEventDispatcher $cartLineEventDispatcher
         * @var CartFactory             $cartFactory
         * @var CartLineFactory         $cartLineFactory
         * @var CartWrapper             $cartWrapper
         */
        $emptyMoneyWrapper = $this->getMock('Elcodi\Component\Currency\Wrapper\EmptyMoneyWrapper', [], [], '', false);
        $currency = new Currency();
        $currency->setIso('EUR');
        $emptyMoneyWrapper
            ->expects($this->any())
            ->method('get')
            ->willReturn(Money::create(0, $currency));

        $cartEventDispatcher = $this->getMock('Elcodi\Component\Cart\EventDispatcher\CartEventDispatcher', [], [], '', false);
        $cartLineEventDispatcher = $this->getMock('Elcodi\Component\Cart\EventDispatcher\CartLineEventDispatcher', [], [], '', false);
        $cartFactory = $this->getMock('Elcodi\Component\Cart\Factory\CartFactory', ['create'], [$emptyMoneyWrapper]);
        $cartLineFactory = $this->getMock('Elcodi\Component\Cart\Factory\CartLineFactory', ['create'], [$emptyMoneyWrapper]);

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
     * addLine with empty cart.
     *
     * @group cart
     */
    public function testAddLineInEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $this->assertEquals(0, $cart->getTotalItemNumber());
        $purchaseable = $this->getMock(
            'Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface'
        );

        $this->cartLineFactory
            ->expects($this->exactly(1))
            ->method('create')
            ->will($this->returnValue(new CartLine()));

        $this->cartManager->addPurchasable($cart, $purchaseable, 1);

        $this->assertCount(1, $cart->getCartLines());
        $this->assertEquals(1, $cart->getTotalItemNumber());
    }

    /**
     * addLine twice with empty cart.
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
            ->addPurchasable($cart, $purchaseable, 1)
            ->addPurchasable($cart, $purchaseable, 1);

        $this->assertCount(1, $cart->getCartLines());
    }

    /**
     * removeLine with a non empty cart.
     *
     * @group cart
     */
    public function testRemoveLineFromNonEmptyCart()
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));
        $cartLine->setCart($cart);

        $this->assertCount(1, $cart->getCartLines());
        $this->cartManager->removeLine($cart, $cartLine);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * removeLine with an empty cart.
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
     * emptyLines with a non empty cart.
     *
     * @group cart
     */
    public function testEmptyLinesFromNonEmptyCart()
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));
        $cartLine->setCart($cart);

        $this->assertCount(1, $cart->getCartLines());
        $this->cartManager->emptyLines($cart);
        $this->assertCount(0, $cart->getCartLines());
    }

    /**
     * emptyLines with an empty cart.
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
     * editCartLine test.
     *
     * @dataProvider dataEditCartLine
     * @group        cart
     */
    public function testEditCartLine($initialQuantity, $newQuantity, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);

        /**
         * @var PurchasableInterface $purchasable
         */
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $cartLine->setQuantity($initialQuantity);
        $cartLine->setPurchasable($purchasable);
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));

        $this->cartManager->editCartLine($cartLine, $purchasable, $newQuantity);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine.
     */
    public function dataEditCartLine()
    {
        return [
            [null, null, null],
            [1, null, 1],
            [1, false, 1],
            [1, 1, 1],
            [null, 1, 1],
            [1, 2, 2],
        ];
    }

    /**
     * increaseCartLineQuantity with empty Cart.
     *
     * @dataProvider dataIncreaseCartLineQuantity
     * @group        cart
     */
    public function testIncreaseCartLineQuantity($initialQuantity, $quantityToIncrease, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));

        $this->cartManager->increaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine.
     */
    public function dataIncreaseCartLineQuantity()
    {
        return [
            [1, null, 1],
            [1, false, 1],
            [1, 1, 2],
            [null, 1, 1],
        ];
    }

    /**
     * increaseCartLineQuantity with empty Cart.
     *
     * @dataProvider dataDecreaseCartLineQuantityNotRemove
     * @group        cart
     */
    public function testDecreaseCartLineQuantityNotRemove($initialQuantity, $quantityToIncrease, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));

        $this->cartManager->decreaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine.
     */
    public function dataDecreaseCartLineQuantityNotRemove()
    {
        return [
            [2, null, 2],
            [2, false, 2],
            [3, 1, 2],
        ];
    }

    /**
     * increaseCartLineQuantity with empty Cart.
     *
     * @dataProvider dataDecreaseCartLineQuantityRemove
     * @group        cart
     */
    public function testDecreaseCartLineQuantityRemove($initialQuantity, $quantityToIncrease)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection([
            $cartLine,
        ]));

        $this->cartManager->decreaseCartLineQuantity($cartLine, $quantityToIncrease);
        $this->assertEmpty($cart->getCartLines());
    }

    /**
     * Data provider for testEditCartLine.
     */
    public function dataDecreaseCartLineQuantityRemove()
    {
        return [
            [1, 1],
            [1, 2],
        ];
    }

    /**
     * addPurchasable.
     *
     * @dataProvider dataAddPurchasable
     * @group        cart
     */
    public function testAddPurchasable($quantity, $purchasableCreated, $quantityExpected)
    {
        $cartLine = new CartLine();
        $this->cartLineFactory
            ->expects($this->exactly(intval($purchasableCreated)))
            ->method('create')
            ->will($this->returnValue($cartLine));

        /**
         * @var PurchasableInterface $purchasable
         */
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());

        $this
            ->cartManager
            ->addPurchasable($cart, $purchasable, $quantity);

        if ($purchasableCreated) {
            $createdLine = $cart->getCartLines()->first();
            $createdPurchasable = $createdLine->getPurchasable();

            $this->assertCount(1, $cart->getCartLines());
            $this->assertInstanceOf('Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface', $createdLine);
            $this->assertSame($createdPurchasable, $purchasable);
            $this->assertEquals($createdLine->getQuantity(), $quantityExpected);
        } else {
            $this->assertCount(0, $cart->getCartLines());
        }
    }

    /**
     * Data provider for testAddPurchasable.
     */
    public function dataAddPurchasable()
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

    /**
     * removePurchasable.
     *
     * @dataProvider dataRemovePurchasable
     * @group        cart
     */
    public function testRemovePurchasable($quantity, $purchasableId, $quantityExpected)
    {
        /**
         * @var PurchasableInterface $purchasable
         */
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $purchasableToRemove = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');

        $purchasable
            ->expects($this->any())
            ->method('getId')
            ->willReturn('1001');

        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setPurchasable($purchasable);
        $cart->setCartLines(new ArrayCollection([$cartLine]));
        $cartLine->setCart($cart);

        $this->assertCount(1, $cart->getCartLines());

        $purchasableToRemove
            ->expects($this->any())
            ->method('getId')
            ->willReturn($purchasableId);

        $this
            ->cartManager
            ->removePurchasable($cart, $purchasableToRemove, $quantity);

        $this->assertCount($quantityExpected, $cart->getCartLines());
    }

    /**
     * Data provider for testRemovePurchasable.
     */
    public function dataRemovePurchasable()
    {
        return [
            [1, 1001, 0],
            [1, 1002, 1],
            [null, 1001, 1],
            [false, 1001, 1],
            [true, 1001, 1],
            [-1, 1001, 1],
        ];
    }
}
