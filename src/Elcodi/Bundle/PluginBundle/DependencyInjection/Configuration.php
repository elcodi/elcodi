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

namespace Elcodi\Bundle\PluginBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files.
 */
class Configuration extends AbstractConfiguration
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
                            'plugin',
                            'Elcodi\Component\Plugin\Entity\Plugin',
                            '@ElcodiPluginBundle/Resources/config/doctrine/Plugin.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'plugin_configuration',
                            'Elcodi\Component\Plugin\Entity\PluginConfiguration',
                            '@ElcodiPluginBundle/Resources/config/doctrine/PluginConfiguration.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->scalarNode('hook_system')
                    ->defaultValue('elcodi.event_dispatcher.hook_system')
                ->end()
            ->end();
    }
}
