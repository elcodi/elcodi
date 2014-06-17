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

namespace Elcodi\RuleBundle\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;

use Elcodi\CoreBundle\Entity\Abstracts\AbstractEntity;
use Elcodi\CoreBundle\Entity\Traits\EnabledTrait;

/**
 * Class AbstractRule
 */
abstract class AbstractRule extends AbstractEntity
{
    use EnabledTrait;

    /**
     * @var string
     *
     * Rule name
     */
    protected $name;

    /**
     * @var string
     *
     * Rule code
     */
    protected $code;

    /**
     * Return all object contained expressions
     *
     * @return Collection Collection of expressions
     */
    abstract public function getExpressionCollection();

    /**
     * Sets Name
     *
     * @param string $name Name
     *
     * @return AbstractRule Self object
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Code
     *
     * @param string $code Code
     *
     * @return AbstractRule Self object
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get Code
     *
     * @return string Code
     */
    public function getCode()
    {
        return $this->code;
    }
}
