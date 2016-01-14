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

namespace Elcodi\Component\Rule\Entity;

use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class Rule.
 */
class Rule implements RuleInterface
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * Name of the rule
     */
    protected $name;

    /**
     * @var string
     *
     * Expression
     */
    protected $expression;

    /**
     * Sets name.
     *
     * @param string $name Name
     *
     * @return $this Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets expression.
     *
     * @param string $expression Expression
     *
     * @return $this Self object
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;

        return $this;
    }

    /**
     * Get expression.
     *
     * @return string Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
