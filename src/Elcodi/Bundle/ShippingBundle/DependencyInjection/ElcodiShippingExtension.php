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

namespace Elcodi\Bundle\ShippingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiShippingExtension
 */
class ElcodiShippingExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_shipping';

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
            "elcodi.entity.carrier.class" => $config['mapping']['carrier']['class'],
            "elcodi.entity.carrier.mapping_file" => $config['mapping']['carrier']['mapping_file'],
            "elcodi.entity.carrier.manager" => $config['mapping']['carrier']['manager'],
            "elcodi.entity.carrier.enabled" => $config['mapping']['carrier']['enabled'],

            "elcodi.entity.shipping_range.class" => $config['mapping']['shipping_range']['class'],
            "elcodi.entity.shipping_range.mapping_file" => $config['mapping']['shipping_range']['mapping_file'],
            "elcodi.entity.shipping_range.manager" => $config['mapping']['shipping_range']['manager'],
            "elcodi.entity.shipping__range.enabled" => $config['mapping']['shipping_range']['enabled'],

            "elcodi.entity.warehouse.class" => $config['mapping']['warehouse']['class'],
            "elcodi.entity.warehouse.mapping_file" => $config['mapping']['warehouse']['mapping_file'],
            "elcodi.entity.warehouse.manager" => $config['mapping']['warehouse']['manager'],
            "elcodi.entity.warehouse.enabled" => $config['mapping']['warehouse']['enabled'],

            "elcodi.resolver.carrier.strategy" => $config['carrier']['resolve_strategy'],
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
            'providers',
            'resolvers',
            'factories',
            'repositories',
            'objectManagers',
            'directors',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface' => 'elcodi.entity.carrier.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\ShippingRangeInterface' => 'elcodi.entity.shipping_range.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface' => 'elcodi.entity.warehouse.class',
        ];
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
