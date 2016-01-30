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

namespace Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class AbstractConfiguration.
 */
abstract class AbstractConfiguration implements ConfigurationInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    protected $extensionName;

    /**
     * Construct method.
     *
     * @var string $extensionName Extension name
     */
    public function __construct($extensionName)
    {
        $this->extensionName = $extensionName;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->extensionName);

        $this->setupTree($rootNode);

        return $treeBuilder;
    }

    /**
     * Configure the root node.
     *
     * @param ArrayNodeDefinition $rootNode Root node
     */
    abstract protected function setupTree(ArrayNodeDefinition $rootNode);

    /**
     * Add a mapping node into configuration.
     *
     * @param string      $nodeName          Node name
     * @param string      $entityClass       Class of the entity
     * @param string      $entityMappingFile Path of the file where the mapping is defined
     * @param string      $entityManager     Name of the entityManager assigned to manage the entity
     * @param string|bool $entityEnabled     The entity mapping will be added to the application
     *
     * @return NodeDefinition Node
     */
    protected function addMappingNode(
        $nodeName,
        $entityClass,
        $entityMappingFile,
        $entityManager,
        $entityEnabled
    ) {
        $builder = new TreeBuilder();
        $node = $builder->root($nodeName);

        $node
            ->treatFalseLike([
                'enabled' => false,
            ])
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('class')
                    ->defaultValue($entityClass)
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('mapping_file')
                    ->defaultValue($entityMappingFile)
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('manager')
                    ->defaultValue($entityManager)
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('enabled')
                    ->defaultValue($entityEnabled)
                ->end()
            ->end()
        ->end();

        return $node;
    }
}
