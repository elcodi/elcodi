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

namespace Elcodi\Component\Rule\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

use Elcodi\Component\Rule\Entity\Interfaces\AbstractRuleInterface;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
use Elcodi\Component\Rule\Repository\AbstractRuleRepository;
use Elcodi\Component\Rule\Services\Interfaces\ContextAwareInterface;
use Elcodi\Component\Rule\Services\Interfaces\ExpressionLanguageAwareInterface;

/**
 * Class RuleManager
 */
class RuleManager implements ContextAwareInterface, ExpressionLanguageAwareInterface
{
    /**
     * @var ExpressionLanguage
     *
     * Expression Language
     */
    protected $expressionLanguage;

    /**
     * @var AbstractRuleRepository
     *
     * Abstract Rule Repository
     */
    protected $abstractRuleRepository;

    /**
     * @var array
     *
     * Context
     */
    protected $context;

    /**
     * Construct method
     *
     * @param ExpressionLanguage     $expressionLanguage     Expression language
     * @param AbstractRuleRepository $abstractRuleRepository Rule Repository
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        AbstractRuleRepository $abstractRuleRepository
    )
    {
        $this->expressionLanguage = $expressionLanguage;
        $this->abstractRuleRepository = $abstractRuleRepository;
        $this->context = array();
    }

    /**
     * Add context element
     *
     * @param Mixed $contextElement Context element
     *
     * @return $this self Object
     */
    public function addContextElement($contextElement)
    {
        $this->context[] = $contextElement;

        return $this;
    }

    /**
     * Get expression language instance
     *
     * @return ExpressionLanguage Expression language instance
     */
    public function getExpressionLanguage()
    {
        return $this->expressionLanguage;
    }

    /**
     * Get context
     *
     * @return array Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Evaluate all rules from a RuleGroup, given its code
     *
     * @param string $code    Rule code
     * @param array  $context Context
     *
     * @return bool Result of evaluation
     */
    public function evaluateByCode($code, array $context = array())
    {
        $rule = $this
            ->abstractRuleRepository
            ->findOneBy(array(
                'code' => $code,
            ));

        if (!($rule instanceof AbstractRuleInterface)) {
            return false;
        }

        return $this->evaluateByRule($rule, $context);
    }

    /**
     * Evaluates a rule
     *
     * @param AbstractRuleInterface $rule    Rule
     * @param array                 $context Context
     *
     * @return boolean Rule evaluation
     */
    public function evaluateByRule(AbstractRuleInterface $rule, array $context = array())
    {
        return $rule
            ->getExpressionCollection()
            ->forAll(function ($_, ExpressionInterface $expression) use ($context) {
                return $this->evaluateExpression($expression, $context);
            });
    }

    /**
     * Evaluates an Expression object
     *
     * @param ExpressionInterface $expression Expression to evaluate
     * @param array               $context    Context
     *
     * @return boolean Result of evaluation
     */
    protected function evaluateExpression(ExpressionInterface $expression, array $context = array())
    {
        $contextMerged = array_merge($this->context, $context);

        try {
            $result = (boolean) $this
                ->expressionLanguage
                ->evaluate($expression->getExpression(), $contextMerged);
        } catch (SyntaxError $exception) {

            $result = false;
        }

        return $result;
    }
}
