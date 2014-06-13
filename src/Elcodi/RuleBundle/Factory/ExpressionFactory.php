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

namespace Elcodi\RuleBundle\Factory;

use Elcodi\CoreBundle\Factory\Abstracts\AbstractFactory;
use Elcodi\RuleBundle\Entity\Expression;

/**
 * Class ExpressionFactory
 */
class ExpressionFactory extends AbstractFactory
{
    /**
     * Creates an instance of an entity.
     *
     * This method must return always an empty instance
     *
     * @return Expression Empty entity
     */
    public function create()
    {
        /**
         * @var Expression $expression
         */
        $classNamespace = $this->getEntityNamespace();
        $expression = new $classNamespace();

        return $expression;
    }
}
