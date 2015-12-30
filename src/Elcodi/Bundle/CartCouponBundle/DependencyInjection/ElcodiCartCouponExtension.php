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

namespace Elcodi\Bundle\CartCouponBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiCartCouponExtension.
 */
class ElcodiCartCouponExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_cart_coupon';

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
            'elcodi.entity.cart_coupon.class' => $config['mapping']['cart_coupon']['class'],
            'elcodi.entity.cart_coupon.mapping_file' => $config['mapping']['cart_coupon']['mapping_file'],
            'elcodi.entity.cart_coupon.manager' => $config['mapping']['cart_coupon']['manager'],
            'elcodi.entity.cart_coupon.enabled' => $config['mapping']['cart_coupon']['enabled'],

            'elcodi.entity.order_coupon.class' => $config['mapping']['order_coupon']['class'],
            'elcodi.entity.order_coupon.mapping_file' => $config['mapping']['order_coupon']['mapping_file'],
            'elcodi.entity.order_coupon.manager' => $config['mapping']['order_coupon']['manager'],
            'elcodi.entity.order_coupon.enabled' => $config['mapping']['order_coupon']['enabled'],
        ];
    }

    /**
     * Config files to load.
     *
     * return array(
     *      'file1.yml',
     *      'file2.yml',
     *      ...
     * );
     *
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'services',
            'eventListeners',
            'factories',
            'services',
            'transformers',
            'repositories',
            'eventDispatchers',
            'objectManagers',
            'directors',
            'applicators',
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
            'Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface' => 'elcodi.entity.cart_coupon.class',
            'Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface' => 'elcodi.entity.order_coupon.class',
        ];
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
