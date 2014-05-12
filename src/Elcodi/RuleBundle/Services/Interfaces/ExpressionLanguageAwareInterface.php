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

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * interface ExpressionLanguageAwareInterface
 */
interface ExpressionLanguageAwareInterface
{
    /**
     * Get expression language instance
     *
     * @return ExpressionLanguage Expression language instance
     */
    public function getExpressionLanguage();
}
