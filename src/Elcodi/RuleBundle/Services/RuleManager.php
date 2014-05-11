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
 
namespace Elcodi\RuleBundle\Services;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

use Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;
use Elcodi\RuleBundle\Repository\RuleGroupRepository;
use Elcodi\RuleBundle\Repository\RuleRepository;

/**
 * Class RuleManager
 */
class RuleManager
{
    /**
     * @var ExpressionLanguage
     *
     * Expression Language
     */
    protected $expressionLanguage;

    /**
     * @var RuleRepository
     *
     * Rule Repository
     */
    protected $ruleRepository;

    /**
     * @var RuleGroupRepository
     *
     * Rule Group Repository
     */
    protected $ruleGroupRepository;

    /**
     * Construct method
     *
     * @param ExpressionLanguage  $expressionLanguage  Expression language
     * @param RuleRepository      $ruleRepository      Rule Repository
     * @param RuleGroupRepository $ruleGroupRepository RuleGroup Repository
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        RuleRepository $ruleRepository,
        RuleGroupRepository $ruleGroupRepository
    )
    {
        $this->expressionLanguage = $expressionLanguage;
        $this->ruleRepository = $ruleRepository;
        $this->ruleGroupRepository = $ruleGroupRepository;
    }

    /**
     * Evaluate all rules from a RuleGroup, given its code
     *
     * @param string $groupCode Group code
     * @param array $context Context
     *
     * @return bool Result of evaluation
     *
     * @api
     */
    public function evaluateGroupCode($groupCode, array $context = array())
    {
        $ruleGroup = $this
            ->ruleGroupRepository
            ->findOneBy(array(
                'code' => $groupCode,
            ));

        if (!($ruleGroup instanceof RuleGroupInterface)) {

            return false;
        }

        /**
         * @var RuleGroupInterface $ruleGroup
         */
        return $this->evaluateGroup($ruleGroup, $context);
    }

    /**
     * Evaluate all rules from a RuleGroup
     *
     * @param RuleGroupInterface $ruleGroup RuleGroup instance
     * @param array $context Context
     *
     * @return bool Result of evaluation
     *
     * @api
     */
    public function evaluateGroup(RuleGroupInterface $ruleGroup, array $context = array())
    {
        return $this->evaluateRules($ruleGroup->getRules(), $context);
    }

    /**
     * Evaluate a collection of Rules
     *
     * @param Collection $rules Collection of rules
     * @param array $context Context
     *
     * @return bool Result of evaluation
     *
     * @api
     */
    public function evaluateRules(Collection $rules, array $context = array())
    {
        return $rules->forAll(function($_, RuleInterface $rule) use ($context){

            return $this->evaluateRule($rule, $context);
        });
    }

    /**
     * Evaluate a single Rule given its code
     *
     * @param string $ruleCode Rule code to evaluate
     * @param array $context Context
     *
     * @return bool Result of evaluation
     *
     * @api
     */
    public function evaluateRuleCode($ruleCode, array $context = array())
    {
        $rule = $this
            ->ruleRepository
            ->findOneBy(array(
                'code' => $ruleCode,
            ));

        if (!($rule instanceof RuleInterface)) {

            return false;
        }

        /**
         * @var RuleInterface $rule
         */
        return $this->evaluateRule($rule, $context);
    }

    /**
     * Evaluate a single Rule
     *
     * @param RuleInterface $rule Rule to evaluate
     * @param array $context Context
     *
     * @return boolean Result of evaluation
     *
     * @api
     */
    public function evaluateRule(RuleInterface $rule, array $context = array())
    {
        return (boolean) $this
            ->expressionLanguage
            ->evaluate($rule->getExpression(), $context);
    }
}
 