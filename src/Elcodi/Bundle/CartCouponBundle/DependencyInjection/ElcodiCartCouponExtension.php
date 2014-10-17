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

namespace Elcodi\Bundle\CartCouponBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * Class ElcodiCartCouponExtension
 */
class ElcodiCartCouponExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_cart_coupon';
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
            "elcodi.core.cart_coupon.entity.cart_coupon.class" => $config['mapping']['cart_coupon']['class'],
            "elcodi.core.cart_coupon.entity.cart_coupon.mapping_file" => $config['mapping']['cart_coupon']['mapping_file'],
            "elcodi.core.cart_coupon.entity.cart_coupon.manager" => $config['mapping']['cart_coupon']['manager'],

            "elcodi.core.cart_coupon.entity.order_coupon.class" => $config['mapping']['order_coupon']['class'],
            "elcodi.core.cart_coupon.entity.order_coupon.mapping_file" => $config['mapping']['order_coupon']['mapping_file'],
            "elcodi.core.cart_coupon.entity.order_coupon.manager" => $config['mapping']['order_coupon']['manager'],
        ];
    }

    /**
     * Config files to load
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
            'classes',
            'services',
            'eventListeners',
            'factories',
            'services',
            'repositories',
            'eventDispatchers',
            'objectManagers',
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
            'Elcodi\Component\CartCoupon\Entity\Interfaces\CartCouponInterface' => 'elcodi.core.cart_coupon.entity.cart_coupon.class',
            'Elcodi\Component\CartCoupon\Entity\Interfaces\OrderCouponInterface' => 'elcodi.core.cart_coupon.entity.order_coupon.class',
        ];
    }
}
