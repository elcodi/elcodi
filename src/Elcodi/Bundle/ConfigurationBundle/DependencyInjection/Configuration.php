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

namespace Elcodi\Bundle\ConfigurationBundle\DependencyInjection;

use Elcodi\Component\Configuration\Adapter\DoctrineParameterFetcher;
use Elcodi\Component\Configuration\Adapter\RedisParameterFetcher;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration extends AbstractConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
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
                            'configuration',
                            'Elcodi\Component\Configuration\Entity\Configuration',
                            '@ElcodiConfigurationBundle/Resources/config/doctrine/Configuration.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
            ->arrayNode('configuration')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('cache_key')
                        ->defaultValue('configuration')
                    ->end()
                    ->enumNode('fetcher')
                        ->values([
                            DoctrineParameterFetcher::ADAPTER_NAME,
                            RedisParameterFetcher::ADAPTER_NAME
                        ])
                        ->defaultValue(DoctrineParameterFetcher::ADAPTER_NAME)
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
