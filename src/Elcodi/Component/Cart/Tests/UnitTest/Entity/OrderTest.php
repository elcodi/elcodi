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

use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;

/**
 * Class OrderTest.
 */
class OrderTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Cart\Entity\Order';
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
                'getter' => 'getCart',
                'setter' => 'setCart',
                'value' => 'Elcodi\Component\Cart\Entity\Interfaces\CartInterface',
                'nullable' => false,
            ]],
            [[
                'type' => $this::ADDER_REMOVER,
                'getter' => 'getOrderLines',
                'setter' => 'setOrderLines',
                'adder' => 'addOrderLine',
                'remover' => 'removeOrderLine',
                'bag' => '\Doctrine\Common\Collections\ArrayCollection',
                'value' => '\Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface',
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getQuantity',
                'setter' => 'setQuantity',
                'value' => 10,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getDeliveryAddress',
                'setter' => 'setDeliveryAddress',
                'value' => 'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface',
                'nullable' => true,
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
                'value' => 'Elcodi\Component\Shipping\Entity\ShippingMethod',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getShippingMethodExtra',
                'setter' => 'setShippingMethodExtra',
                'value' => ['extra-information'],
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getPaymentMethod',
                'setter' => 'setPaymentMethod',
                'value' => 'Elcodi\Component\Payment\Entity\PaymentMethod',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getPaymentMethodExtra',
                'setter' => 'setPaymentMethodExtra',
                'value' => ['extra-information'],
                'nullable' => false,
            ]],
        ];
    }
}
