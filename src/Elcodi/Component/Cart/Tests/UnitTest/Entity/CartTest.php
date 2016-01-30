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

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Cart\Entity\Cart;
use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

/**
 * Class CartTest.
 */
class CartTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Cart\Entity\Cart';
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
                'getter' => 'getCustomer',
                'setter' => 'setCustomer',
                'value' => 'Elcodi\Component\User\Entity\Interfaces\CustomerInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getOrder',
                'setter' => 'setOrder',
                'value' => 'Elcodi\Component\Cart\Entity\Interfaces\OrderInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'isOrdered',
                'setter' => 'setOrdered',
                'value' => true,
                'nullable' => false,
            ]],
            [[
                'type' => $this::ADDER_REMOVER,
                'getter' => 'getCartLines',
                'setter' => 'setCartLines',
                'adder' => 'addCartLine',
                'remover' => 'removeCartLine',
                'bag' => '\Doctrine\Common\Collections\ArrayCollection',
                'value' => '\Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface',
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getPurchasableAmount',
                'setter' => 'setPurchasableAmount',
                'value' => 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCouponAmount',
                'setter' => 'setCouponAmount',
                'value' => 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getShippingAmount',
                'setter' => 'setShippingAmount',
                'value' => 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getAmount',
                'setter' => 'setAmount',
                'value' => 'Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getDeliveryAddress',
                'setter' => 'setDeliveryAddress',
                'value' => 'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getBillingAddress',
                'setter' => 'setBillingAddress',
                'value' => 'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getShippingMethod',
                'setter' => 'setShippingMethod',
                'value' => 'my-shipping-method',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCheapestShippingMethod',
                'setter' => 'setCheapestShippingMethod',
                'value' => 'my-shipping-method',
                'nullable' => false,
            ]],
        ];
    }

    /**
     * Test total item numbers.
     *
     * @dataProvider dataGetTotalItemNumber
     */
    public function testGetTotalItemNumber(array $quantities, $total)
    {
        $cartLines = new ArrayCollection([]);
        foreach ($quantities as $quantity) {
            if ($quantity > 0) {
                $cartLine = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface');
                $cartLine
                    ->method('getQuantity')
                    ->will($this->returnValue($quantity));
                $cartLines->add($cartLine);
            }
        }
        $cart = new Cart();
        $cart->setCartLines($cartLines);
        $this->assertEquals(
            $total,
            $cart->getTotalItemNumber()
        );
    }

    /**
     * Data for testGetTotalItemNumber.
     */
    public function dataGetTotalItemNumber()
    {
        return [
            [[1, 2, 3], 6],
            [[0, 0, 1], 1],
            [[3], 3],
            [[0], 0],
        ];
    }

    /**
     * Test get height.
     *
     * @dataProvider dataGetDimensions
     */
    public function testGetDimensions(array $dimensions, $total)
    {
        $cartLines = new ArrayCollection([]);
        foreach ($dimensions as $dimension) {
            $cartLine = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface');
            $cartLine
                ->method('getHeight')
                ->will($this->returnValue($dimension));
            $cartLine
                ->method('getWidth')
                ->will($this->returnValue($dimension));
            $cartLine
                ->method('getDepth')
                ->will($this->returnValue($dimension));
            $cartLines->add($cartLine);
        }
        $cart = new Cart();
        $cart->setCartLines($cartLines);
        $this->assertEquals(
            $total,
            $cart->getHeight()
        );
        $this->assertEquals(
            $total,
            $cart->getWidth()
        );
        $this->assertEquals(
            $total,
            $cart->getDepth()
        );
    }

    /**
     * Data for testGetDimensions.
     */
    public function dataGetDimensions()
    {
        return [
            [[1, 2, 3], 3],
            [[0, 0, 1], 1],
            [[3], 3],
            [[0], 0],
            [[-1], 0],
        ];
    }

    /**
     * Test get width.
     *
     * @dataProvider dataGetWeight
     */
    public function testGetWeight(array $weights, $total)
    {
        $cartLines = new ArrayCollection([]);
        foreach ($weights as $weight) {
            $cartLine = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface');
            $cartLine
                ->method('getWeight')
                ->will($this->returnValue($weight));
            $cartLines->add($cartLine);
        }
        $cart = new Cart();
        $cart->setCartLines($cartLines);
        $this->assertEquals(
            $total,
            $cart->getWeight()
        );
    }

    /**
     * Data for testGetWeight.
     */
    public function dataGetWeight()
    {
        return [
            [[1, 2, 3], 6],
            [[0, 0, 1], 1],
            [[3], 3],
            [[0], 0],
            [[-1], -1],
        ];
    }
}
