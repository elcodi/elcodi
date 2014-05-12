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

namespace Elcodi\RuleBundle\Configuration\Interfaces;

use Elcodi\RuleBundle\Services\Interfaces\ExpressionLanguageAwareInterface;

/**
 * Interface ExpressionLanguageConfigurationInterface
 */
interface ExpressionLanguageConfigurationInterface
{
    /**
     * Configures
     *
     * @param ExpressionLanguageAwareInterface $expressionLanguageAware Expression Language aware
     */
    public function configureExpressionLanguage(ExpressionLanguageAwareInterface $expressionLanguageAware);
}
