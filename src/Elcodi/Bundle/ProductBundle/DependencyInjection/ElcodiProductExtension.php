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

namespace Elcodi\Bundle\ProductBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiProductExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_product';

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
            "elcodi.entity.product.class"                => $config['mapping']['product']['class'],
            "elcodi.entity.product.mapping_file"         => $config['mapping']['product']['mapping_file'],
            "elcodi.entity.product.manager"              => $config['mapping']['product']['manager'],
            "elcodi.entity.product.enabled"              => $config['mapping']['product']['enabled'],

            "elcodi.entity.product_variant.class"        => $config['mapping']['product_variant']['class'],
            "elcodi.entity.product_variant.mapping_file" => $config['mapping']['product_variant']['mapping_file'],
            "elcodi.entity.product_variant.manager"      => $config['mapping']['product_variant']['manager'],
            "elcodi.entity.product_variant.enabled"      => $config['mapping']['product_variant']['enabled'],

            "elcodi.entity.category.class"               => $config['mapping']['category']['class'],
            "elcodi.entity.category.mapping_file"        => $config['mapping']['category']['mapping_file'],
            "elcodi.entity.category.manager"             => $config['mapping']['category']['manager'],
            "elcodi.entity.category.enabled"             => $config['mapping']['category']['enabled'],

            "elcodi.entity.manufacturer.class"           => $config['mapping']['manufacturer']['class'],
            "elcodi.entity.manufacturer.mapping_file"    => $config['mapping']['manufacturer']['mapping_file'],
            "elcodi.entity.manufacturer.manager"         => $config['mapping']['manufacturer']['manager'],
            "elcodi.entity.manufacturer.enabled"         => $config['mapping']['manufacturer']['enabled'],

            'elcodi.core.product.use_stock'                           => $config['products']['use_stock'],
            'elcodi.core.product.load_only_categories_with_products'  => $config['categories']['load_only_categories_with_products'],
            'elcodi.core.product.cache_key'                           => $config['categories']['cache_key'],
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
            'services',
            'factories',
            'repositories',
            'objectManagers',
            'twig',
            'directors',
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
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface'      => 'elcodi.entity.product.class',
            'Elcodi\Component\Product\Entity\Interfaces\VariantInterface'      => 'elcodi.entity.product_variant.class',
            'Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface' => 'elcodi.entity.manufacturer.class',
            'Elcodi\Component\Product\Entity\Interfaces\CategoryInterface'     => 'elcodi.entity.category.class',
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
