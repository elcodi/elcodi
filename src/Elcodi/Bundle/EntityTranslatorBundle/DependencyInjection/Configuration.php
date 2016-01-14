<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\EntityTranslatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Configure the root node.
     *
     * @param ArrayNodeDefinition $rootNode
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
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
                ->arrayNode('language')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('master_locale')
                            ->defaultValue('en')
                        ->end()
                        ->scalarNode('fallback')
                            ->defaultTrue()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('configuration')
                    ->useAttributeAsKey('name')
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
                                ->beforeNormalization()
                                ->always(function ($fields) {
                                    foreach ($fields as $fieldName => $fieldConfiguration) {
                                        if (!is_array($fieldConfiguration)) {
                                            $fieldConfiguration = [];
                                        }

                                        if (!isset($fieldConfiguration['getter'])) {
                                            $fields[$fieldName]['getter'] = 'get' . ucfirst($fieldName);
                                        }

                                        if (!isset($fieldConfiguration['setter'])) {
                                            $fields[$fieldName]['setter'] = 'set' . ucfirst($fieldName);
                                        }
                                    }

                                    return $fields;
                                })
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
