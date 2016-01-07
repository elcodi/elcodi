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

namespace Elcodi\Component\Cart\Tests\UnitTest\Entity;

use Elcodi\Component\Cart\Entity\CartLine;
use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

/**
 * Class CartLineTest.
 */
class CartLineTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Cart\Entity\CartLine';
    }

    /**
     * Return the fields to test in entities.
     *
     * [
     *      [[
     *          "type" => $this::GETTER_SETTER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *          "nullable" => true
     *      ]],
     *      [[
     *          "type" => $this::ADDER_REMOVER|$this::ADDER_REMOVER,
     *          "getter" => "getValue",
     *          "setter" => "setValue",
     *          "adder" => "addValue",
     *          "removed" => "removeValue",
     *          "bag" => "collection", // can be array
     *          "value" => "Elcodi\Component\...\Interfaces\AnInterface"
     *      ]]
     * ]
     *
     * @return array Fields
     */
    public function getTestableFields()
    {
        return [
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCart',
                'setter' => 'setCart',
                'value' => 'Elcodi\Component\Cart\Entity\Interfaces\CartInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getOrderLine',
                'setter' => 'setOrderLine',
                'value' => 'Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface',
                'nullable' => false,
            ]],
        ];
    }

    /**
     * Test space dimensions (width, height, depth).
     *
     * @dataProvider dataGetSpaceDimensions
     */
    public function testGetSpaceDimensions($method)
    {
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $purchasable
            ->method($method)
            ->will($this->returnValue(5));

        $cartLine = new CartLine();
        $cartLine->setPurchasable($purchasable);
        $this->assertEquals(
            5,
            $cartLine->$method()
        );

        $variant = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $variant
            ->method('getPurchasable')
            ->will($this->returnValue($purchasable));
        $variant
            ->method($method)
            ->will($this->returnValue(10));

        $cartLine = new CartLine();
        $cartLine->setPurchasable($variant);
        $this->assertEquals(
            10,
            $cartLine->$method()
        );
    }

    /**
     * Data for testGetSpaceDimensions.
     */
    public function dataGetSpaceDimensions()
    {
        return [
            ['getWidth'],
            ['getHeight'],
            ['getDepth'],
        ];
    }

    /**
     * Test get weight.
     */
    public function testGetWeight()
    {
        $purchasable = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface');
        $purchasable
            ->method('getWeight')
            ->will($this->returnValue(5));

        $cartLine = new CartLine();
        $cartLine->setPurchasable($purchasable);
        $cartLine->setQuantity(2);
        $this->assertEquals(
            10,
            $cartLine->getWeight()
        );

        $variant = $this->getMock('Elcodi\Component\Product\Entity\Interfaces\VariantInterface');
        $variant
            ->method('getPurchasable')
            ->will($this->returnValue($purchasable));
        $variant
            ->method('getWeight')
            ->will($this->returnValue(10));

        $cartLine = new CartLine();
        $cartLine->setPurchasable($variant);
        $cartLine->setQuantity(3);
        $this->assertEquals(
            30,
            $cartLine->getWeight()
        );
    }
}
