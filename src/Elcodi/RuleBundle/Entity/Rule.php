<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\RuleBundle\Entity\Abstracts\AbstractRule;
use Elcodi\RuleBundle\Entity\Interfaces\ExpressionInterface;
use Elcodi\RuleBundle\Entity\Interfaces\RuleInterface;

/**
 * Class Rule
 */
class Rule extends AbstractRule implements RuleInterface
{
    /**
     * @var ExpressionInterface
     *
     * Expression
     */
    protected $expression;

    /**
     * Sets Expression
     *
     * @param ExpressionInterface $expression Expression
     *
     * @return Rule Self object
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * Get Expression
     *
     * @return ExpressionInterface Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * Return all object contained expressions
     *
     * @return ArrayCollection Collection of expressions
     */
    public function getExpressionCollection()
    {
        return new ArrayCollection(array($this->getExpression()));
    }
}
