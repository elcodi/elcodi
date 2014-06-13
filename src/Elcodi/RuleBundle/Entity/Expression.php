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

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\RuleBundle\Entity\Interfaces\ExpressionInterface;

/**
 * Class Expression
 */
class Expression extends AbstractEntity implements ExpressionInterface
{
    /**
     * @var string
     *
     * Expression
     */
    protected $expression;

    /**
     * Sets Expression
     *
     * @param string $expression Expression
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
     * @return string Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
