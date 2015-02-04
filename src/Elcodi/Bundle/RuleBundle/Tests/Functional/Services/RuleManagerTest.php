<?php

/*
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

namespace Elcodi\Bundle\RuleBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Rule\Entity\Rule;
use Elcodi\Component\Rule\Services\RuleManager;

/**
 * Class RuleManagerTest
 */
class RuleManagerTest extends WebTestCase
{
    /**
     * @var RuleManager
     *
     * Rule manager
     */
    protected $ruleManager;

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.rule.service.rule_manager',
            'elcodi.rule_manager',
        ];
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiRuleBundle',
        );
    }

    /**
     * Set up
     */
    public function setUp()
    {
        parent::setUp();

        $this->ruleManager = $this->get('elcodi.rule_manager');
    }

    /**
     * Test if it can evaluate simple rules
     */
    public function testEvaluateSimpleRule()
    {
        $rule = new Rule();
        $rule->setExpression('cart.getQuantity() < 10');

        $cart = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart->expects($this->any())->method('getQuantity')->willReturn(5);

        $context = [
            'cart' => $cart,
        ];

        $this->assertTrue($this->ruleManager->evaluate($rule, $context));
    }

    /**
     * Evaluate compound rules
     *
     * @dataProvider providerEvaluateCompoundRule
     *
     * @param integer $amount
     * @param integer $quantity
     * @param boolean $expected
     */
    public function testEvaluateCompoundRule($amount, $quantity, $expected)
    {
        $rule = new Rule();
        $rule->setExpression('rule("cart_valuable_items")');

        $cart = $this->getMock('Elcodi\Component\Cart\Entity\Interfaces\CartInterface');
        $cart->expects($this->any())->method('getAmount')->willReturn($amount);
        $cart->expects($this->any())->method('getQuantity')->willReturn($quantity);

        $context = [
            'cart' => $cart,
        ];

        $this->assertEquals($expected, $this->ruleManager->evaluate($rule, $context));
    }

    /**
     * Tests for "cart.getAmount() > 1000 and cart.getQuantity() < 10"
     *
     * @return array
     */
    public function providerEvaluateCompoundRule()
    {
        return [
           [  100, 20, false ],
           [ 1100, 20, false ],
           [  100,  5, false ],
           [ 1100,  5, true  ],
       ];
    }
}
