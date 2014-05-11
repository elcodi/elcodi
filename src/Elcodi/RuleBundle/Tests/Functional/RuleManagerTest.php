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
 
namespace Elcodi\RuleBundle\Tests\Functional;

use Elcodi\CoreBundle\Tests\WebTestCase;
use Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface;
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
        return 'elcodi.core.rule.services.rule_manager';
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
            ->get('elcodi.core.rule.services.rule_manager');
    }

    /**
     * Evaluate rule true
     *
     * @var RuleInterface $ruleTrue
     */
    public function testEvaluateRuleTrue()
    {
        $ruleTrue = $this
            ->manager
            ->getRepository('ElcodiRuleBundle:Rule')
            ->findOneBy(array(
                'code' => 'rule-true'
            ));

        $this->assertTrue($this->ruleManager->evaluateRule($ruleTrue));
    }

    /**
     * Evaluate rule false
     *
     * @var RuleInterface $ruleGroupFalse
     */
    public function testEvaluateRuleFalse()
    {
        $ruleFalse = $this
            ->manager
            ->getRepository('ElcodiRuleBundle:Rule')
            ->findOneBy(array(
                'code' => 'rule-false'
            ));

        $this->assertFalse($this->ruleManager->evaluateRule($ruleFalse));
    }

    /**
     * Evaluate rule true
     */
    public function testEvaluateRuleCodeTrue()
    {
        $this->assertTrue($this->ruleManager->evaluateRuleCode('rule-true'));
    }

    /**
     * Evaluate rule false
     */
    public function testEvaluateRuleCodeFalse()
    {
        $this->assertFalse($this->ruleManager->evaluateRuleCode('rule-false'));
    }

    /**
     * Evaluate rule group
     *
     * @var RuleGroupInterface $ruleGroupTrue
     */
    public function testEvaluateRuleGroupTrue()
    {
        $ruleGroupTrue = $this
            ->manager
            ->getRepository('ElcodiRuleBundle:RuleGroup')
            ->findOneBy(array(
                'code' => 'rule-group-true'
            ));

        $this->assertTrue($this->ruleManager->evaluateGroup($ruleGroupTrue));
    }

    /**
     * Evaluate rule group
     *
     * @var RuleGroupInterface $ruleGroupFalse
     */
    public function testEvaluateRuleGroupFalse()
    {
        $ruleGroupFalse = $this
            ->manager
            ->getRepository('ElcodiRuleBundle:RuleGroup')
            ->findOneBy(array(
                'code' => 'rule-group-false'
            ));

        $this->assertFalse($this->ruleManager->evaluateGroup($ruleGroupFalse));
    }

    /**
     * Evaluate rule group
     */
    public function testEvaluateRuleGroupCodeTrue()
    {
        $this->assertTrue($this->ruleManager->evaluateGroupCode('rule-group-true'));
    }

    /**
     * Evaluate rule group
     */
    public function testEvaluateRuleGroupCodeFalse()
    {
        $this->assertFalse($this->ruleManager->evaluateGroupCode('rule-group-false'));
    }
}
 