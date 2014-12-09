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

namespace Elcodi\Bundle\EntityTranslatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->extensionName);

        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'translation',
                            'Elcodi\Component\EntityTranslator\Entity\EntityTranslation',
                            '@ElcodiEntityTranslatorBundle/Resources/config/doctrine/EntityTranslation.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->scalarNode('cache_prefix')
                    ->defaultValue('translation')
                ->end()
                ->booleanNode('auto_translate')
                    ->defaultTrue()
                ->end()
                ->arrayNode('configuration')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('alias')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('idGetter')
                                ->defaultValue('getId')
                            ->end()
                            ->arrayNode('fields')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('setter')->end()
                                        ->scalarNode('getter')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
