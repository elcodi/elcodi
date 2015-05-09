<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Rule\ExpressionLanguage\Provider;

use Doctrine\Common\Persistence\ObjectRepository;
use RuntimeException;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

use Elcodi\Component\Rule\Entity\Rule;
use Elcodi\Component\Rule\Repository\RuleRepository;
use Elcodi\Component\Rule\Services\RuleManager;

/**
 * Class RuleProvider
 *
 * Extends ExpressionLanguage to access rules from repository
 */
class RuleProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @var RuleRepository
     *
     * Rule repository
     */
    protected $ruleRepository;

    /**
     * @var RuleManager
     *
     * Rule manager
     */
    protected $ruleManager;

    /**
     * Construct method
     *
     * @param ObjectRepository $ruleRepository Rule repository
     * @param RuleManager      $ruleManager    Rule manager
     */
    public function __construct(ObjectRepository $ruleRepository, RuleManager $ruleManager)
    {
        $this->ruleRepository = $ruleRepository;
        $this->ruleManager = $ruleManager;
    }

    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        return [
            /**
             * Evaluate a rule by name
             */
            new ExpressionFunction(
                'rule',
                function ($arg) {
                    throw new RuntimeException(
                        'Function "rule" can\'t be compiled.'
                    );
                },
                function (array $context, $value) {
                    /**
                     * @var Rule $rule
                     */
                    $rule = $this
                        ->ruleRepository
                        ->findOneById($value);

                    return $rule ? $this->ruleManager->evaluate($rule, $context) : false;
                }
            ),
        ];
    }
}
