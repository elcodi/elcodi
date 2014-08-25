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

namespace Elcodi\Component\Rule\Entity;

use Elcodi\Component\Core\Entity\Abstracts\AbstractEntity;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;

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
