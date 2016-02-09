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

namespace Elcodi\Component\Coupon\Tests\Entity;

use Elcodi\Component\Core\Tests\UnitTest\Entity\AbstractEntityTest;
use Elcodi\Component\Coupon\ElcodiCouponTypes;
use Elcodi\Component\Currency\Entity\Currency;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Rule\Entity\Rule;

/**
 * Class CouponTest.
 */
class CouponTest extends AbstractEntityTest
{
    /**
     * Return the entity namespace.
     *
     * @return string Entity namespace
     */
    public function getEntityNamespace()
    {
        return 'Elcodi\Component\Coupon\Entity\Coupon';
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
        $currency = new Currency();
        $currency->setIso('EUR');
        $currency->setSymbol('€');

        return [
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCode',
                'setter' => 'setCode',
                'value' => 'discount',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getName',
                'setter' => 'setName',
                'value' => 'Discount',
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getEnforcement',
                'setter' => 'setEnforcement',
                'value' => ElcodiCouponTypes::ENFORCEMENT_AUTOMATIC,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getPrice',
                'setter' => 'setPrice',
                'value' => Money::create(1000, $currency),
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getDiscount',
                'setter' => 'setDiscount',
                'value' => 10,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getAbsolutePrice',
                'setter' => 'setAbsolutePrice',
                'value' => Money::create(1000, $currency),
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getValue',
                'setter' => 'setValue',
                'value' => 'value',
                'nullable' => true,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getCount',
                'setter' => 'setCount',
                'value' => 10,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getUsed',
                'setter' => 'setUsed',
                'value' => 10,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getPriority',
                'setter' => 'setPriority',
                'value' => 10,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getMinimumPurchase',
                'setter' => 'setMinimumPurchase',
                'value' => Money::create(1000, $currency),
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getStackable',
                'setter' => 'setStackable',
                'value' => true,
                'nullable' => false,
            ]],
            [[
                'type' => $this::GETTER_SETTER,
                'getter' => 'getRule',
                'setter' => 'setRule',
                'value' => new Rule(),
                'nullable' => true,
            ]],
        ];
    }
}
