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

namespace Elcodi\Bundle\GeoBundle\DependencyInjection;

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
                ->arrayNode('mapping')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addMappingNode(
                            'address',
                            'Elcodi\Component\Geo\Entity\Address',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Address.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'location',
                            'Elcodi\Component\Geo\Entity\Location',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Location.orm.yml',
                            'default',
                            true
                        ))
                    ->end()
                ->end()
                ->arrayNode('populator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')
                            ->defaultValue('elcodi.geo.geodata_populator_adapter')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
