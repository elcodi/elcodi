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

namespace Elcodi\Component\Rule\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\Component\Rule\Entity\Abstracts\AbstractRule;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

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
