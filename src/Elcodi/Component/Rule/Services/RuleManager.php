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

namespace Elcodi\Component\Rule\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;
use Elcodi\Component\Rule\ExpressionLanguage\Interfaces\ExpressionContextProviderInterface;
use Elcodi\Component\Rule\Services\Interfaces\RuleManagerInterface;

/**
 * Class RuleManager.
 */
class RuleManager implements RuleManagerInterface
{
    /**
     * @var ExpressionLanguage
     *
     * Expression Language
     */
    private $expressionLanguage;

    /**
     * @var ExpressionContextProviderInterface
     *
     * Context
     */
    private $contextProvider;

    /**
     * Construct method.
     *
     * @param ExpressionLanguage                 $expressionLanguage Expression language
     * @param ExpressionContextProviderInterface $contextProvider    Context provider
     */
    public function __construct(
        ExpressionLanguage $expressionLanguage,
        ExpressionContextProviderInterface $contextProvider
    ) {
        $this->expressionLanguage = $expressionLanguage;
        $this->contextProvider = $contextProvider;
    }

    /**
     * Evaluates a rule and returns result.
     *
     * @param RuleInterface $rule
     * @param array         $context
     *
     * @return mixed
     */
    public function evaluate(RuleInterface $rule, array $context = [])
    {
        $context = array_merge(
            $this->contextProvider->getContext(),
            $context
        );

        return $this
            ->expressionLanguage
            ->evaluate($rule->getExpression(), $context);
    }
}
