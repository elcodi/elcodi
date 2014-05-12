<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\RuleBundle\Services\Interfaces;

/**
 * Interface ContextAwareInterface
 */
interface ContextAwareInterface
{
    /**
     * Add context element
     *
     * @param Mixed $contextElement Context element
     *
     * @return ContextAwareInterface self Object
     */
    public function addContextElement($contextElement);
}
