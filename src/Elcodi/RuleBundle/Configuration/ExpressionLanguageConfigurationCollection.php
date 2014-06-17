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

namespace Elcodi\RuleBundle\Configuration;

use Elcodi\RuleBundle\Configuration\Interfaces\ExpressionLanguageConfigurationInterface;

/**
 * Class ExpressionLanguageConfigurationCollection
 */
class ExpressionLanguageConfigurationCollection
{
    /**
     * @var array
     *
     * Array of ExpressionLanguageConfiguration objects
     */
    protected $expressionLanguageConfigurations;

    /**
     * Construct method
     */
    public function __construct()
    {
        $this->expressionLanguageConfigurations = array();
    }

    /**
     * Add ExpressionLanguageConfiguration configuration
     *
     * @param ExpressionLanguageConfigurationInterface $expressionLanguageConfiguration ExpressionLanguage Configuration
     */
    public function addExpressionLanguageConfiguration(
        ExpressionLanguageConfigurationInterface $expressionLanguageConfiguration
    )
    {
        $this->expressionLanguageConfigurations[] = $expressionLanguageConfiguration;
    }

    /**
     * Get all context configuration objects
     *
     * @return array Array of all added context configurations
     */
    public function getExpressionLanguageConfigurations()
    {
        return $this->expressionLanguageConfigurations;
    }
}
