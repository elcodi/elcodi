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

namespace Elcodi\Bundle\GeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Elcodi\Component\Geo\Adapter\Populator\DummyPopulatorAdapter;
use Elcodi\Component\Geo\Adapter\Populator\GeoDataPopulatorAdapter;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiGeoExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_geo';
    }

    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public function getConfigFilesLocation()
    {
        return __DIR__ . '/../Resources/config';
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
        return new Configuration();
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
            "elcodi.core.geo.entity.country.class" => $config['mapping']['country']['class'],
            "elcodi.core.geo.entity.country.mapping_file" => $config['mapping']['country']['mapping_file'],
            "elcodi.core.geo.entity.country.manager" => $config['mapping']['country']['manager'],

            "elcodi.core.geo.entity.state.class" => $config['mapping']['state']['class'],
            "elcodi.core.geo.entity.state.mapping_file" => $config['mapping']['state']['mapping_file'],
            "elcodi.core.geo.entity.state.manager" => $config['mapping']['state']['manager'],

            "elcodi.core.geo.entity.province.class" => $config['mapping']['province']['class'],
            "elcodi.core.geo.entity.province.mapping_file" => $config['mapping']['province']['mapping_file'],
            "elcodi.core.geo.entity.province.manager" => $config['mapping']['province']['manager'],

            "elcodi.core.geo.entity.city.class" => $config['mapping']['city']['class'],
            "elcodi.core.geo.entity.city.mapping_file" => $config['mapping']['city']['mapping_file'],
            "elcodi.core.geo.entity.city.manager" => $config['mapping']['city']['manager'],

            "elcodi.core.geo.entity.postal_code.class" => $config['mapping']['postal_code']['class'],
            "elcodi.core.geo.entity.postal_code.mapping_file" => $config['mapping']['postal_code']['mapping_file'],
            "elcodi.core.geo.entity.postal_code.manager" => $config['mapping']['postal_code']['manager'],

            "elcodi.core.geo.entity.address.class" => $config['mapping']['address']['class'],
            "elcodi.core.geo.entity.address.mapping_file" => $config['mapping']['address']['mapping_file'],
            "elcodi.core.geo.entity.address.manager" => $config['mapping']['address']['manager'],

            "elcodi.core.geo.entity.zone.class" => $config['mapping']['zone']['class'],
            "elcodi.core.geo.entity.zone.mapping_file" => $config['mapping']['zone']['mapping_file'],
            "elcodi.core.geo.entity.zone.manager" => $config['mapping']['zone']['manager'],

            "elcodi.core.geo.entity.zone_member.class" => $config['mapping']['zone_member']['class'],
            "elcodi.core.geo.entity.zone_member.mapping_file" => $config['mapping']['zone_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_member.manager" => $config['mapping']['zone_member']['manager'],

            "elcodi.core.geo.entity.zone_country_member.class" => $config['mapping']['zone_country_member']['class'],
            "elcodi.core.geo.entity.zone_country_member.mapping_file" => $config['mapping']['zone_country_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_country_member.manager" => $config['mapping']['zone_country_member']['manager'],

            "elcodi.core.geo.entity.zone_state_member.class" => $config['mapping']['zone_state_member']['class'],
            "elcodi.core.geo.entity.zone_state_member.mapping_file" => $config['mapping']['zone_state_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_state_member.manager" => $config['mapping']['zone_state_member']['manager'],

            "elcodi.core.geo.entity.zone_province_member.class" => $config['mapping']['zone_province_member']['class'],
            "elcodi.core.geo.entity.zone_province_member.mapping_file" => $config['mapping']['zone_province_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_province_member.manager" => $config['mapping']['zone_province_member']['manager'],

            "elcodi.core.geo.entity.zone_city_member.class" => $config['mapping']['zone_city_member']['class'],
            "elcodi.core.geo.entity.zone_city_member.mapping_file" => $config['mapping']['zone_city_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_city_member.manager" => $config['mapping']['zone_city_member']['manager'],

            "elcodi.core.geo.entity.zone_postal_code_member.class" => $config['mapping']['zone_postal_code_member']['class'],
            "elcodi.core.geo.entity.zone_postal_code_member.mapping_file" => $config['mapping']['zone_postal_code_member']['mapping_file'],
            "elcodi.core.geo.entity.zone_postal_code_member.manager" => $config['mapping']['zone_postal_code_member']['manager'],
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
            'factories',
            'repositories',
            'services',
            'objectManagers',
            'commands',
            [
                'populatorAdapters/geodataPopulator',
                $config['populator']['client'] === GeoDataPopulatorAdapter::ADAPTER_NAME
            ],
            [
                'populatorAdapters/dummyPopulator',
                $config['populator']['client'] === DummyPopulatorAdapter::ADAPTER_NAME
            ],
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
            'Elcodi\Component\Geo\Entity\Interfaces\CountryInterface' => 'elcodi.core.geo.entity.country.class',
            'Elcodi\Component\Geo\Entity\Interfaces\StateInterface' => 'elcodi.core.geo.entity.state.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ProvinceInterface' => 'elcodi.core.geo.entity.province.class',
            'Elcodi\Component\Geo\Entity\Interfaces\CityInterface' => 'elcodi.core.geo.entity.city.class',
            'Elcodi\Component\Geo\Entity\Interfaces\PostalCodeInterface' => 'elcodi.core.geo.entity.postal_code.class',
            'Elcodi\Component\Geo\Entity\Interfaces\AddressInterface' => 'elcodi.core.geo.entity.address.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface' => 'elcodi.core.geo.entity.zone.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneMemberInterface' => 'elcodi.core.geo.entity.zone_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneCountryMemberInterface' => 'elcodi.core.geo.entity.zone_country_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneStateMemberInterface' => 'elcodi.core.geo.entity.zone_state_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneProvinceMemberInterface' => 'elcodi.core.geo.entity.zone_province_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZoneCityMemberInterface' => 'elcodi.core.geo.entity.zone_city_member.class',
            'Elcodi\Component\Geo\Entity\Interfaces\ZonePostalCodeMemberInterface' => 'elcodi.core.geo.entity.zone_postal_code_member.class',
        ];
    }
}
