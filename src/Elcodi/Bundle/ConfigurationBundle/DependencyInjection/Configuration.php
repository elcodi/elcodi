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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Bundle\ConfigurationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;
use Elcodi\Component\Configuration\ElcodiConfigurationTypes;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Configure the root node
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
                            'configuration',
                            'Elcodi\Component\Configuration\Entity\Configuration',
                            '@ElcodiConfigurationBundle/Resources/config/doctrine/Configuration.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('elements')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('key')
                                ->isRequired()
                            ->end()
                            ->scalarNode('name')
                                ->isRequired()
                            ->end()
                            ->scalarNode('namespace')
                                ->defaultValue('')
                            ->end()
                            ->enumNode('type')
                                ->values([
                                    ElcodiConfigurationTypes::TYPE_BOOLEAN,
                                    ElcodiConfigurationTypes::TYPE_STRING,
                                    ElcodiConfigurationTypes::TYPE_TEXT,
                                    ElcodiConfigurationTypes::TYPE_ARRAY
                                ])
                            ->end()
                            ->scalarNode('reference')
                                ->defaultNull()
                            ->end()
                            ->variableNode('default_value')
                                ->defaultNull()
                            ->end()
                            ->scalarNode('can_be_empty')
                                ->defaultTrue()
                            ->end()
                            ->scalarNode('empty_message')
                                ->defaultValue('')
                            ->end()
                            ->booleanNode('read_only')
                                ->defaultFalse()
                            ->end()
                        ->end()
                    ->end()
                    ->beforeNormalization()
                        ->always(function (array $elements) {

                            $newElements = [];
                            foreach ($elements as $element) {

                                $completeParameterName = isset($element['namespace'])
                                    ? $element['namespace'] . '.' . $element['key']
                                    : $element['key'];

                                $newElements[$completeParameterName] = $element;
                            }

                            return $newElements;
                        })
                    ->end()
                ->end()
            ->end();
    }
}
