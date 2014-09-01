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

namespace Elcodi\Bundle\RuleBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Rule\Entity\Interfaces\AbstractRuleInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;
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
     * @return array Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.rule.service.rule_manager',
            'elcodi.rule_manager'
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
     * Evaluate rule true
     *
     * @var RuleInterface $ruleTrue
     */
    public function testEvaluateRuleTrue()
    {
        $ruleTrue = $this
            ->getRepository('abstract_rule')
            ->findOneBy(array(
                'code' => 'rule-group-true'
            ));

        $this->assertTrue($this->ruleManager->evaluateByRule($ruleTrue));
    }

    /**
     * Evaluate rule false
     *
     * @var RuleInterface $ruleFalse
     */
    public function testEvaluateRuleFalse()
    {
        $ruleFalse = $this
            ->getRepository('abstract_rule')
            ->findOneBy(array(
                'code' => 'rule-false'
            ));

        $this->assertFalse($this->ruleManager->evaluateByRule($ruleFalse));
    }

    /**
     * Evaluate rule with variables
     *
     * @var RuleInterface $ruleParameter
     */
    public function testEvaluateRuleParameter()
    {
        $ruleParameter = $this
            ->getRepository('abstract_rule')
            ->findOneBy(array(
                'code' => 'rule-variables'
            ));

        /**
         * @var AbstractRuleInterface $ruleParameter
         */
        $this->assertTrue($this->ruleManager->evaluateByRule($ruleParameter, array(
            'parameter_value' => 'value',
        )));
    }

    /**
     * Evaluate rule with variable with exception
     *
     * @var RuleInterface $ruleParameter
     */
    public function testEvaluateRuleParameterException()
    {
        $ruleParameter = $this
            ->getRepository('abstract_rule')
            ->findOneBy(array(
                'code' => 'rule-variables'
            ));

        /**
         * @var AbstractRuleInterface $ruleParameter
         */
        $this->assertFalse($this->ruleManager->evaluateByRule($ruleParameter, array(
            'parameter_another_value' => 'value',
        )));
    }

    /**
     * Evaluate rule true
     */
    public function testEvaluateRuleCodeTrue()
    {
        $this->assertTrue($this->ruleManager->evaluateByCode('rule-true'));
    }

    /**
     * Evaluate rule false
     */
    public function testEvaluateRuleCodeFalse()
    {
        $this->assertFalse($this->ruleManager->evaluateByCode('rule-false'));
    }
}
