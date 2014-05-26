<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\Tests\Functional\Services;

use Elcodi\CoreBundle\Tests\WebTestCase;
use Elcodi\RuleBundle\Entity\Interfaces\AbstractRuleInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;
use Elcodi\RuleBundle\Services\RuleManager;

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
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
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

        $this->ruleManager = $this
            ->container
            ->get('elcodi.rule_manager');
    }

    /**
     * Evaluate rule true
     *
     * @var RuleInterface $ruleTrue
     */
    public function testEvaluateRuleTrue()
    {
        $ruleTrue = $this
            ->getRepository('elcodi.core.rule.entity.abstract_rule.class')
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
            ->getRepository('elcodi.core.rule.entity.abstract_rule.class')
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
            ->getRepository('elcodi.core.rule.entity.abstract_rule.class')
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
            ->getRepository('elcodi.core.rule.entity.abstract_rule.class')
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
