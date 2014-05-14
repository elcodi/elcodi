<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since  2013
 */

namespace Elcodi\CartBundle\Tests\UnitTest\Services;

use Elcodi\CartBundle\Entity\Cart;
use Elcodi\CartBundle\Entity\CartLine;
use Elcodi\CartBundle\Entity\Interfaces\CartInterface;
use Elcodi\CartBundle\Factory\CartFactory;
use Elcodi\CartBundle\Factory\CartLineFactory;
use Elcodi\CartBundle\Services\CartManager;
use Elcodi\ProductBundle\Entity\Interfaces\ProductInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PHPUnit_Framework_TestCase;

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
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * Set up
     *
     */
    public function setUp()
    {
        /**
         * @var ObjectManager            $manager
         * @var EventDispatcherInterface $eventDispatcher
         * @var CartFactory              $cartFactory
         * @var CartLineFactory          $cartLineFactory
         */
        $manager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $cartFactory = $this->getMock('Elcodi\CartBundle\Factory\CartFactory');
        $cartLineFactory = $this->getMock('Elcodi\CartBundle\Factory\CartLineFactory');

        $this->cartManager = new CartManager(
            $manager,
            $eventDispatcher,
            $cartFactory,
            $cartLineFactory
        );
    }

    /**
     * addLine with empty cart
     */
    public function testAddLineInEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $cartLine = new CartLine();

        $this->cartManager->addLine($cart, $cartLine);
        $this->assertCount(1, $cart->getCartLines());
    }

    /**
     * addLine twice with empty cart
     */
    public function testAddLineTwiceInEmptyCart()
    {
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection());
        $cartLine = new CartLine();

        $this
            ->cartManager
            ->addLine($cart, $cartLine)
            ->addLine($cart, $cartLine);
        $this->assertCount(1, $cart->getCartLines());
    }

    /**
     * removeLine with a non empty cart
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
     */
    public function testEditCartLine($initialQuantity, $newQuantity, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);

        /**
         * @var ProductInterface $product
         */
        $product = $this->getMock('Elcodi\ProductBundle\Entity\Interfaces\ProductInterface');
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
     * @dataProvider dataIncreaseCartLineQuantityNotDefined
     */
    public function testIncreaseCartLineQuantityNotDefined($initialQuantity, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->increaseCartLineQuantity($cartLine);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataIncreaseCartLineQuantityNotDefined()
    {
        return array(
            array(1, 2),
            array(null, 1),
            array(false, 1),
        );
    }

    /**
     * increaseCartLineQuantity with empty Cart
     *
     * @dataProvider dataDecreaseCartLineQuantityNotRemove
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
     * @dataProvider dataDecreaseCartLineQuantityNotRemoveNotDefined
     */
    public function testDecreaseCartLineQuantityNotRemoveNotDefined($initialQuantity, $finalQuantity)
    {
        $cart = new Cart();
        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setQuantity($initialQuantity);
        $cart->setCartLines(new ArrayCollection(array(
            $cartLine
        )));

        $this->cartManager->decreaseCartLineQuantity($cartLine);
        $this->assertEquals($finalQuantity, $cartLine->getQuantity());
    }

    /**
     * Data provider for testEditCartLine
     */
    public function dataDecreaseCartLineQuantityNotRemoveNotDefined()
    {
        return array(
            array(2, 1),
        );
    }

    /**
     * increaseCartLineQuantity with empty Cart
     *
     * @dataProvider dataDecreaseCartLineQuantityRemove
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
     */
    public function testAddProduct()
    {
        /**
         * @var ObjectManager            $manager
         * @var EventDispatcherInterface $eventDispatcher
         * @var CartFactory              $cartFactory
         * @var CartLineFactory          $cartLineFactory
         */
        $manager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $eventDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $cartFactory = $this->getMock('Elcodi\CartBundle\Factory\CartFactory');
        $cartLineFactory = $this
            ->getMockBuilder('Elcodi\CartBundle\Factory\CartLineFactory')
            ->setMethods(array(
                'create',
            ))
            ->getMock();

        $cartLine = new CartLine();
        $cartLineFactory
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($cartLine));

        $this->cartManager = new CartManager(
            $manager,
            $eventDispatcher,
            $cartFactory,
            $cartLineFactory
        );

        /**
         * @var ProductInterface $product
         */
        $product = $this->getMock('Elcodi\ProductBundle\Entity\Interfaces\ProductInterface');
        $cart = new Cart();
        $cart->setCartLines(new ArrayCollection);

        $this->cartManager->addProduct($cart, $product);
        $this->assertCount(1, $cart->getCartLines());
        $this->assertInstanceOf('Elcodi\CartBundle\Entity\Interfaces\CartLineInterface', $cart->getCartLines()->first());
        $this->assertSame($cart->getCartLines()->first()->getProduct(), $product);
    }
}
