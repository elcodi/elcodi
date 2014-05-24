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

namespace Elcodi\RuleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiRuleExtension
 */
class ElcodiRuleExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read all
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration();
    }

    /**
     * Config files to load
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'services',
            'factories',
            'configurations',
            'repositories',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\RuleBundle\Entity\Interfaces\RuleInterface' => 'elcodi.core.rule.entity.rule.class',
            'Elcodi\RuleBundle\Entity\Interfaces\RuleGroupInterface' => 'elcodi.core.rule.entity.rule_group.class',
            'Elcodi\RuleBundle\Entity\Interfaces\ExpressionInterface' => 'elcodi.core.rule.entity.expression.class',
        ];
    }
}
