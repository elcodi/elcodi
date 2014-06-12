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

namespace Elcodi\RuleBundle\Entity\Interfaces;

/**
 * Class ExpressionInterface
 */
interface ExpressionInterface
{
    /**
     * Sets Expression
     *
     * @param string $expression Expression
     *
     * @return ExpressionInterface Self object
     */
    public function setExpression($expression);

    /**
     * Get Expression
     *
     * @return string Expression
     */
    public function getExpression();
}
