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

namespace Elcodi\Component\Cart\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Cart\Entity\CartLine;
use Elcodi\Component\Core\Tests\Entity\Traits;

class CartLineTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait;

    const CART_CLASS = 'Elcodi\Component\Cart\Entity\Interfaces\CartInterface';
    const ORDER_LINE_CLASS = 'Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface';
    const PRODUCT_INTERFACE = 'Elcodi\Component\Product\Entity\Interfaces\ProductInterface';

    /**
     * @var CartLine
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CartLine();
    }

    public function testCart()
    {
        $cart = $this->getMock(self::CART_CLASS);

        $setterOutput = $this->object->setCart($cart);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getCart();
        $this->assertSame($cart, $getterOutput);
    }

    public function testOrderLine()
    {
        $cart = $this->getMock(self::ORDER_LINE_CLASS);

        $setterOutput = $this->object->setOrderLine($cart);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOrderLine();
        $this->assertSame($cart, $getterOutput);
    }

    public function testGetDepth()
    {
        $productMock = $this->getMock(self::PRODUCT_INTERFACE);

        $depth = rand();

        $productMock
            ->method('getDepth')
            ->willReturn($depth);

        $this->object->setPurchasable($productMock);

        $this->assertSame($depth, $this->object->getDepth());
    }

    public function testGetHeight()
    {
        $productMock = $this->getMock(self::PRODUCT_INTERFACE);

        $height = rand();

        $productMock
            ->method('getHeight')
            ->willReturn($height);

        $this->object->setPurchasable($productMock);

        $this->assertSame($height, $this->object->getHeight());
    }

    public function testGetWidth()
    {
        $productMock = $this->getMock(self::PRODUCT_INTERFACE);

        $width = rand();

        $productMock
            ->method('getWidth')
            ->willReturn($width);

        $this->object->setPurchasable($productMock);

        $this->assertSame($width, $this->object->getWidth());
    }

    public function testGetWeight()
    {
        $productMock = $this->getMock(self::PRODUCT_INTERFACE);

        $weight = rand();

        $productMock
            ->method('getWeight')
            ->willReturn($weight);

        $this->object->setPurchasable($productMock);

        $this->assertSame($weight, $this->object->getWeight());
    }
}
