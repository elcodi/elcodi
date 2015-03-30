<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Bundle\MetricBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractConfiguration;

/**
 * Class Configuration
 */
class Configuration extends AbstractConfiguration
{
    /**
     * {@inheritDoc}
     */
    protected function setupTree(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'metric_entry',
                            'Elcodi\Component\Metric\Core\Entity\Entry',
                            '@ElcodiMetricBundle/Resources/config/doctrine/Entry.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()

                ->arrayNode('input')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('controller_route_name')
                            ->defaultValue('elcodi_metric_add')
                        ->end()
                        ->scalarNode('controller_route')
                            ->defaultValue('/_m/{token}/{event}.png')
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('bucket')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')
                            ->defaultValue('elcodi.redis_metrics_bucket')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
