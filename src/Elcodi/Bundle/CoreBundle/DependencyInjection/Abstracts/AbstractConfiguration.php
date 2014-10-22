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

namespace Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class AbstractConfiguration
 */
class AbstractConfiguration
{
    /**
     * Add a mapping node into configuration
     *
     * @param string  $nodeName          Node name
     * @param string  $entityClass       Class of the entity
     * @param string  $entityMappingFile Path of the file where the mapping is defined
     * @param string  $entityManager     Name of the entityManager assigned to manage the entity
     * @param boolean $entityEnabled     The entity mapping will be added to the application
     *
     * @return NodeDefinition Node
     */
    protected function addMappingNode(
        $nodeName,
        $entityClass,
        $entityMappingFile,
        $entityManager,
        $entityEnabled
    )
    {
        $builder = new TreeBuilder();
        $node = $builder->root($nodeName);

        $node
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
                    ->defaultValue(true)
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ->end();

        return $node;
    }
}
