<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('elcodi_referral_program');

        $rootNode
            ->children()
                ->scalarNode('controller_route_name')
                    ->defaultValue('elcodi_referralprogram_track')
                ->end()
                ->scalarNode('controller_route')
                    ->defaultValue('/referralprogram/track/{hash}')
                ->end()
                ->scalarNode('controller_redirect')
                    ->defaultValue('homepage')
                ->end()
                ->booleanNode('purge_disabled_lines')
                    ->defaultFalse()
                ->end()
                ->booleanNode('auto_referral_assignment')
                    ->defaultTrue()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
