<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
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
     * Get the Config file location.
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
     * ConfigurationInterface, extension will use the Configuration to read allpurchasable_pack
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
     * Load Parametrization definition.
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
            'elcodi.entity.purchasable.class' => $config['mapping']['purchasable']['class'],
            'elcodi.entity.purchasable.mapping_file' => $config['mapping']['purchasable']['mapping_file'],
            'elcodi.entity.purchasable.manager' => $config['mapping']['purchasable']['manager'],
            'elcodi.entity.purchasable.enabled' => $config['mapping']['purchasable']['enabled'],

            'elcodi.entity.product.class' => $config['mapping']['product']['class'],
            'elcodi.entity.product.mapping_file' => $config['mapping']['product']['mapping_file'],
            'elcodi.entity.product.manager' => $config['mapping']['product']['manager'],
            'elcodi.entity.product.enabled' => $config['mapping']['product']['enabled'],

            'elcodi.entity.product_variant.class' => $config['mapping']['product_variant']['class'],
            'elcodi.entity.product_variant.mapping_file' => $config['mapping']['product_variant']['mapping_file'],
            'elcodi.entity.product_variant.manager' => $config['mapping']['product_variant']['manager'],
            'elcodi.entity.product_variant.enabled' => $config['mapping']['product_variant']['enabled'],

            'elcodi.entity.purchasable_pack.class' => $config['mapping']['purchasable_pack']['class'],
            'elcodi.entity.purchasable_pack.mapping_file' => $config['mapping']['purchasable_pack']['mapping_file'],
            'elcodi.entity.purchasable_pack.manager' => $config['mapping']['purchasable_pack']['manager'],
            'elcodi.entity.purchasable_pack.enabled' => $config['mapping']['purchasable_pack']['enabled'],

            'elcodi.entity.category.class' => $config['mapping']['category']['class'],
            'elcodi.entity.category.mapping_file' => $config['mapping']['category']['mapping_file'],
            'elcodi.entity.category.manager' => $config['mapping']['category']['manager'],
            'elcodi.entity.category.enabled' => $config['mapping']['category']['enabled'],

            'elcodi.entity.manufacturer.class' => $config['mapping']['manufacturer']['class'],
            'elcodi.entity.manufacturer.mapping_file' => $config['mapping']['manufacturer']['mapping_file'],
            'elcodi.entity.manufacturer.manager' => $config['mapping']['manufacturer']['manager'],
            'elcodi.entity.manufacturer.enabled' => $config['mapping']['manufacturer']['enabled'],

            'elcodi.core.product.use_stock' => $config['products']['use_stock'],
            'elcodi.core.product.load_only_categories_with_products' => $config['categories']['load_only_categories_with_products'],
            'elcodi.core.product.cache_key' => $config['categories']['cache_key'],
        ];
    }

    /**
     * Config files to load.
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
            'eventListeners',
            'adapters',
            'nameResolvers',
            'stockUpdaters',
            'stockValidators',
            'imageResolvers',
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
            'Elcodi\Component\Product\Entity\Interfaces\PurchasableInterface' => 'elcodi.entity.purchasable.class',
            'Elcodi\Component\Product\Entity\Interfaces\ProductInterface' => 'elcodi.entity.product.class',
            'Elcodi\Component\Product\Entity\Interfaces\VariantInterface' => 'elcodi.entity.product_variant.class',
            'Elcodi\Component\Product\Entity\Interfaces\PackInterface' => 'elcodi.entity.purchasable_pack.class',
            'Elcodi\Component\Product\Entity\Interfaces\ManufacturerInterface' => 'elcodi.entity.manufacturer.class',
            'Elcodi\Component\Product\Entity\Interfaces\CategoryInterface' => 'elcodi.entity.category.class',
        ];
    }

    /**
     * Post load implementation.
     *
     * @param array            $config    Parsed configuration
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $relatedProductsAdapterId = $config['related_purchasables_provider']['adapter'];
        $container->setAlias(
            'elcodi.related_purchasables_provider',
            $relatedProductsAdapterId
        );
    }

    /**
     * Returns the extension alias, same value as extension name.
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return static::EXTENSION_NAME;
    }
}
