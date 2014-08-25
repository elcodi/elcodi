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

namespace Elcodi\Bundle\RuleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(ElcodiRuleExtension::getExtensionName());

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('abstract_rule')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Rule\Entity\Abstracts\AbstractRule')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiRuleBundle/Resources/config/doctrine/AbstractRule.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('expression')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Rule\Entity\Expression')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiRuleBundle/Resources/config/doctrine/Expression.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('rule')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Rule\Entity\Rule')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiRuleBundle/Resources/config/doctrine/Rule.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('rule_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('Elcodi\Component\Rule\Entity\RuleGroup')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('mapping_file')
                                    ->defaultValue('@ElcodiRuleBundle/Resources/config/doctrine/RuleGroup.orm.yml')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('manager')
                                    ->defaultValue('default')
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
