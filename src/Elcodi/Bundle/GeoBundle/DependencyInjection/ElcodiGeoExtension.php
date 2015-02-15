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

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiGeoExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_geo';

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__.'/../Resources/config';
    }

    /**
     * Return a new Configuration instance.
     *
     * If object returned by this method is an instance of
     * ConfigurationInterface, extension will use the Configuration to read all
     * bundle config definitions.
     *
     * Also will call getParametrizationValues method to load some config values
     * to internal parameters.
     *
     * @return ConfigurationInterface Configuration file
     */
    protected function getConfigurationInstance()
    {
        return new Configuration(static::EXTENSION_NAME);
    }

    /**
     * Load Parametrization definition
     *
     * return array(
     *      'parameter1' => $config['parameter1'],
     *      'parameter2' => $config['parameter2'],
     *      ...
     * );
     *
     * @param array $config Bundles config values
     *
     * @return array Parametrization values
     */
    protected function getParametrizationValues(array $config)
    {
        return [
            "elcodi.core.geo.entity.country.class"                        => $config['mapping']['country']['class'],
            "elcodi.core.geo.entity.country.mapping_file"                 => $config['mapping']['country']['mapping_file'],
            "elcodi.core.geo.entity.country.manager"                      => $config['mapping']['country']['manager'],
            "elcodi.core.geo.entity.country.enabled"                      => $config['mapping']['country']['enabled'],

            "elcodi.core.geo.entity.state.class"                          => $config['mapping']['state']['class'],
            "elcodi.core.geo.entity.state.mapping_file"                   => $config['mapping']['state']['mapping_file'],
            "elcodi.core.geo.entity.state.manager"                        => $config['mapping']['state']['manager'],
            "elcodi.core.geo.entity.state.enabled"                        => $config['mapping']['state']['enabled'],

            "elcodi.core.geo.entity.province.class"                       => $config['mapping']['province']['class'],
            "elcodi.core.geo.entity.province.mapping_file"                => $config['mapping']['province']['mapping_file'],
            "elcodi.core.geo.entity.province.manager"                     => $config['mapping']['province']['manager'],
            "elcodi.core.geo.entity.province.enabled"                     => $config['mapping']['province']['enabled'],

            "elcodi.core.geo.entity.city.class"                           => $config['mapping']['city']['class'],
            "elcodi.core.geo.entity.city.mapping_file"                    => $config['mapping']['city']['mapping_file'],
            "elcodi.core.geo.entity.city.manager"                         => $config['mapping']['city']['manager'],
            "elcodi.core.geo.entity.city.enabled"                         => $config['mapping']['city']['enabled'],

            "elcodi.core.geo.entity.postal_code.class"                    => $config['mapping']['postal_code']['class'],
            "elcodi.core.geo.entity.postal_code.mapping_file"             => $config['mapping']['postal_code']['mapping_file'],
            "elcodi.core.geo.entity.postal_code.manager"                  => $config['mapping']['postal_code']['manager'],
            "elcodi.core.geo.entity.postal_code.enabled"                  => $config['mapping']['postal_code']['enabled'],

            "elcodi.core.geo.entity.address.class"                        => $config['mapping']['address']['class'],
            "elcodi.core.geo.entity.address.mapping_file"                 => $config['mapping']['address']['mapping_file'],
            "elcodi.core.geo.entity.address.manager"                      => $config['mapping']['address']['manager'],
            "elcodi.core.geo.entity.address.enabled"                      => $config['mapping']['address']['enabled'],

            "elcodi.core.geo.entity.zone.class"                           => $config['mapping']['zone']['class'],
            "elcodi.core.geo.entity.zone.mapping_file"                    => $config['mapping']['zone']['mapping_file'],
            "elcodi.core.geo.entity.zone.manager"                         => $config['mapping']['zone']['manager'],
            "elcodi.core.geo.entity.zone.enabled"                         => $config['mapping']['zone']['enabled'],

            "elcodi.core.geo.entity.zone_member.class"                    => $config['mapping']['zone_member']['class'],
            "elcodi.core.geo.entity.zone_member.mapping_file"             => $config['mapping']['zone_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_member.manager"                  => $config['mapping']['zone_member']['manager'],
            "elcodi.core.geo.entity.zone_member.enabled"                  => $config['mapping']['zone_member']['enabled'],

            "elcodi.core.geo.entity.zone_country_member.class"            => $config['mapping']['zone_country_member']['class'],
            "elcodi.core.geo.entity.zone_country_member.mapping_file"     => $config['mapping']['zone_country_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_country_member.manager"          => $config['mapping']['zone_country_member']['manager'],
            "elcodi.core.geo.entity.zone_country_member.enabled"          => $config['mapping']['zone_country_member']['enabled'],

            "elcodi.core.geo.entity.zone_state_member.class"              => $config['mapping']['zone_state_member']['class'],
            "elcodi.core.geo.entity.zone_state_member.mapping_file"       => $config['mapping']['zone_state_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_state_member.manager"            => $config['mapping']['zone_state_member']['manager'],
            "elcodi.core.geo.entity.zone_state_member.enabled"            => $config['mapping']['zone_state_member']['enabled'],

            "elcodi.core.geo.entity.zone_province_member.class"           => $config['mapping']['zone_province_member']['class'],
            "elcodi.core.geo.entity.zone_province_member.mapping_file"    => $config['mapping']['zone_province_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_province_member.manager"         => $config['mapping']['zone_province_member']['manager'],
            "elcodi.core.geo.entity.zone_province_member.enabled"         => $config['mapping']['zone_province_member']['enabled'],

            "elcodi.core.geo.entity.zone_city_member.class"               => $config['mapping']['zone_city_member']['class'],
            "elcodi.core.geo.entity.zone_city_member.mapping_file"        => $config['mapping']['zone_city_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_city_member.manager"             => $config['mapping']['zone_city_member']['manager'],
            "elcodi.core.geo.entity.zone_city_member.enabled"             => $config['mapping']['zone_city_member']['enabled'],

            "elcodi.core.geo.entity.zone_postal_code_member.class"        => $config['mapping']['zone_postal_code_member']['class'],
            "elcodi.core.geo.entity.zone_postal_code_member.mapping_file" => $config['mapping']['zone_postal_code_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_postal_code_member.manager"      => $config['mapping']['zone_postal_code_member']['manager'],
            "elcodi.core.geo.entity.zone_postal_code_member.enabled"      => $config['mapping']['zone_postal_code_member']['enabled'],

            "elcodi.entity.location.class"                                => $config['mapping']['location']['class'],
            "elcodi.entity.location.mapping_file"                         => $config['mapping']['location']['mapping_file'],
            "elcodi.entity.location.manager"                              => $config['mapping']['location']['manager'],
            "elcodi.entity.location.enabled"                              => $config['mapping']['location']['enabled'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Configuration
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'directors',
            'factories',
            'repositories',
            'services',
            'objectManagers',
            'commands',
            'populatorAdapters',
            'transformers',
        ];
    }

    /**
     * Get entities overrides.
     *
     * Result must be an array with:
     * index: Original Interface
     * value: Parameter where class is defined.
     *
     * @return array Overrides definition
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Geo\Entity\Interfaces\CountryInterface'              => 'elcodi.core.geo.entity.country.class',
            'Elcodi\Component\Geo\Entity\Interfaces\StateInterface'                => 'elcodi.core.geo.entity.state.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface'             => 'elcodi.core.geo.entity.province.class',
            'Elcodi\Component\Geo\Entity\Interfaces\CityInterface'                 => 'elcodi.core.geo.entity.city.class',
            'Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface'           => 'elcodi.core.geo.entity.postal_code.class',
            'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface'              => 'elcodi.core.geo.entity.address.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface'                 => 'elcodi.core.geo.entity.zone.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberInterface'           => 'elcodi.core.geo.entity.zone_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface'    => 'elcodi.core.geo.entity.zone_country_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface'      => 'elcodi.core.geo.entity.zone_state_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface'   => 'elcodi.core.geo.entity.zone_province_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface'       => 'elcodi.core.geo.entity.zone_city_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface' => 'elcodi.core.geo.entity.zone_postal_code_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\LocationInterface'             => 'elcodi.entity.location.class',
        ];
    }

    /**
     * Post load implementation
     *
     * @param array            $config    Parsed configuration
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $populatorClientId = $config['populator']['client'];
        $container->setAlias('elcodi.geo.populator_adapter', $populatorClientId);
    }

    /**
     * Returns the extension alias, same value as extension name
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
