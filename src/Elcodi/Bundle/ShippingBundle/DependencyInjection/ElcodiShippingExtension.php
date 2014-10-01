<?php

/**
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
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_shipping';
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
            "elcodi.core.shipping.entity.carrier.class" => $config['mapping']['carrier']['class'],
            "elcodi.core.shipping.entity.carrier.mapping_file" => $config['mapping']['carrier']['mapping_file'],
            "elcodi.core.shipping.entity.carrier.manager" => $config['mapping']['carrier']['manager'],

            "elcodi.core.shipping.entity.carrier_range.class" => $config['mapping']['carrier_range']['class'],
            "elcodi.core.shipping.entity.carrier_range.mapping_file" => $config['mapping']['carrier_range']['mapping_file'],
            "elcodi.core.shipping.entity.carrier_range.manager" => $config['mapping']['carrier_range']['manager'],

            "elcodi.core.shipping.entity.carrier_price_range.class" => $config['mapping']['carrier_price_range']['class'],
            "elcodi.core.shipping.entity.carrier_price_range.mapping_file" => $config['mapping']['carrier_price_range']['mapping_file'],
            "elcodi.core.shipping.entity.carrier_price_range.manager" => $config['mapping']['carrier_price_range']['manager'],

            "elcodi.core.shipping.entity.carrier_weight_range.class" => $config['mapping']['carrier_weight_range']['class'],
            "elcodi.core.shipping.entity.carrier_weight_range.mapping_file" => $config['mapping']['carrier_weight_range']['mapping_file'],
            "elcodi.core.shipping.entity.carrier_weight_range.manager" => $config['mapping']['carrier_weight_range']['manager'],

            "elcodi.core.shipping.entity.warehouse.class" => $config['mapping']['warehouse']['class'],
            "elcodi.core.shipping.entity.warehouse.mapping_file" => $config['mapping']['warehouse']['mapping_file'],
            "elcodi.core.shipping.entity.warehouse.manager" => $config['mapping']['warehouse']['manager'],

            "elcodi.core.shipping.carrier_resolver_strategy" => $config['carrier']['resolve_strategy'],
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
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\Component\Shipping\Entity\Interfaces\CarrierInterface' => 'elcodi.core.shipping.entity.carrier.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\CarrierRangeInterface' => 'elcodi.core.shipping.entity.carrier_range.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\CarrierPriceInterface' => 'elcodi.core.shipping.entity.carrier_price_range.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\CarrierWeightInterface' => 'elcodi.core.shipping.entity.carrier_weight_range.class',
            'Elcodi\Component\Shipping\Entity\Interfaces\WarehouseInterface' => 'elcodi.core.shipping.entity.warehouse.class',
        ];
    }
}
