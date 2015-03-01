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

namespace Elcodi\Bundle\BambooBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 */
class Configuration extends AbstractConfiguration
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
                ->scalarNode('cache_prefix')
                    ->defaultValue('')
                ->end()
                ->scalarNode('store_name')
                    ->defaultValue('Elcodi Store')
                ->end()
                ->scalarNode('store_slug')
                    ->defaultValue('elcodi-store')
                ->end()
                ->scalarNode('store_tracker')
                    ->isRequired()
                ->end()
                ->scalarNode('store_enabled')
                    ->defaultTrue()
                ->end()
                ->scalarNode('store_under_construction')
                    ->defaultTrue()
                ->end()
                ->scalarNode('store_address')
                    ->defaultValue('Store address')
                ->end()
            ->end();
    }
}
