<?php

/*
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

namespace Elcodi\Bundle\RuleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

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
    public static function getExtensionName()
    {
        return 'elcodi_rule';
    }

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
     * Load Parametrization definition
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            "elcodi.core.rule.entity.abstract_rule.class" => $config['mapping']['abstract_rule']['class'],
            "elcodi.core.rule.entity.abstract_rule.mapping_file" => $config['mapping']['abstract_rule']['mapping_file'],
            "elcodi.core.rule.entity.abstract_rule.manager" => $config['mapping']['abstract_rule']['manager'],

            "elcodi.core.rule.entity.expression.class" => $config['mapping']['expression']['class'],
            "elcodi.core.rule.entity.expression.mapping_file" => $config['mapping']['expression']['mapping_file'],
            "elcodi.core.rule.entity.expression.manager" => $config['mapping']['expression']['manager'],

            "elcodi.core.rule.entity.rule.class" => $config['mapping']['rule']['class'],
            "elcodi.core.rule.entity.rule.mapping_file" => $config['mapping']['rule']['mapping_file'],
            "elcodi.core.rule.entity.rule.manager" => $config['mapping']['rule']['manager'],

            "elcodi.core.rule.entity.rule_group.class" => $config['mapping']['rule_group']['class'],
            "elcodi.core.rule.entity.rule_group.mapping_file" => $config['mapping']['rule_group']['mapping_file'],
            "elcodi.core.rule.entity.rule_group.manager" => $config['mapping']['rule_group']['manager'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'services',
            'factories',
            'configurations',
            'repositories',
            'objectManagers',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Rule\Entity\Interfaces\RuleInterface' => 'elcodi.core.rule.entity.rule.class',
            'Elcodi\Component\Rule\Entity\Interfaces\RuleGroupInterface' => 'elcodi.core.rule.entity.rule_group.class',
            'Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface' => 'elcodi.core.rule.entity.expression.class',
        ];
    }
}
