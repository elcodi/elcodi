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
                            'country',
                            'Elcodi\Component\Geo\Entity\Country',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Country.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'state',
                            'Elcodi\Component\Geo\Entity\State',
                            '@ElcodiGeoBundle/Resources/config/doctrine/State.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'province',
                            'Elcodi\Component\Geo\Entity\Province',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Province.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'city',
                            'Elcodi\Component\Geo\Entity\City',
                            '@ElcodiGeoBundle/Resources/config/doctrine/City.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'postal_code',
                            'Elcodi\Component\Geo\Entity\PostalCode',
                            '@ElcodiGeoBundle/Resources/config/doctrine/PostalCode.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'address',
                            'Elcodi\Component\Geo\Entity\Address',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Address.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone',
                            'Elcodi\Component\Geo\Entity\Zone',
                            '@ElcodiGeoBundle/Resources/config/doctrine/Zone.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_member',
                            'Elcodi\Component\Geo\Entity\ZoneMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZoneMember.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_country_member',
                            'Elcodi\Component\Geo\Entity\ZoneCountryMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZoneCountryMember.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_state_member',
                            'Elcodi\Component\Geo\Entity\ZoneStateMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZoneStateMember.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_province_member',
                            'Elcodi\Component\Geo\Entity\ZoneProvinceMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZoneProvinceMember.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_city_member',
                            'Elcodi\Component\Geo\Entity\ZoneCityMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZoneCityMember.orm.yml',
                            'default',
                            true
                        ))
                        ->append($this->addMappingNode(
                            'zone_postal_code_member',
                            'Elcodi\Component\Geo\Entity\ZonePostalCodeMember',
                            '@ElcodiGeoBundle/Resources/config/doctrine/ZonePostalCodeMember.orm.yml',
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
