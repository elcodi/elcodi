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

namespace Elcodi\RuleBundle\Entity\Interfaces;

/**
 * Class RuleInterface
 */
interface RuleInterface extends AbstractRuleInterface
{
    /**
     * Sets Expression
     *
     * @param string $expression Expression
     *
     * @return RuleInterface Self object
     */
    public function setExpression($expression);

    /**
     * Get Expression
     *
     * @return ExpressionInterface Expression
     */
    public function getExpression();
}
