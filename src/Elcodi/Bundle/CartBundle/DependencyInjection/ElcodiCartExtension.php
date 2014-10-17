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

namespace Elcodi\Bundle\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiCartExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * Get the Config file location
     *
     * @return string Config file location
     */
    public static function getExtensionName()
    {
        return 'elcodi_cart';
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
            "elcodi.core.cart.entity.cart.class" => $config['mapping']['cart']['class'],
            "elcodi.core.cart.entity.cart.mapping_file" => $config['mapping']['cart']['mapping_file'],
            "elcodi.core.cart.entity.cart.manager" => $config['mapping']['cart']['manager'],

            "elcodi.core.cart.entity.order.class" => $config['mapping']['order']['class'],
            "elcodi.core.cart.entity.order.mapping_file" => $config['mapping']['order']['mapping_file'],
            "elcodi.core.cart.entity.order.manager" => $config['mapping']['order']['manager'],

            "elcodi.core.cart.entity.cart_line.class" => $config['mapping']['cart_line']['class'],
            "elcodi.core.cart.entity.cart_line.mapping_file" => $config['mapping']['cart_line']['mapping_file'],
            "elcodi.core.cart.entity.cart_line.manager" => $config['mapping']['cart_line']['manager'],

            "elcodi.core.cart.entity.order_line.class" => $config['mapping']['order_line']['class'],
            "elcodi.core.cart.entity.order_line.mapping_file" => $config['mapping']['order_line']['mapping_file'],
            "elcodi.core.cart.entity.order_line.manager" => $config['mapping']['order_line']['manager'],

            "elcodi.core.cart.entity.order_history.class" => $config['mapping']['order_history']['class'],
            "elcodi.core.cart.entity.order_history.mapping_file" => $config['mapping']['order_history']['mapping_file'],
            "elcodi.core.cart.entity.order_history.manager" => $config['mapping']['order_history']['manager'],

            "elcodi.core.cart.entity.order_line_history.class" => $config['mapping']['order_line_history']['class'],
            "elcodi.core.cart.entity.order_line_history.mapping_file" => $config['mapping']['order_line_history']['mapping_file'],
            "elcodi.core.cart.entity.order_line_history.manager" => $config['mapping']['order_line_history']['manager'],

            'elcodi.core.cart.cart_save_in_session' => $config['cart']['save_in_session'],
            'elcodi.core.cart.cart_session_field_name' => $config['cart']['session_field_name'],

            'elcodi.core.cart.order_states' => $config['order']['states'],
            'elcodi.core.cart.order_initial_state' => $config['order']['initial_state'],
        ];
    }

    /**
     * Config files to load
     *
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'classes',
            'eventListeners',
            'services',
            'factories',
            'repositories',
            'objectManagers',
            'transformers',
            'eventDispatchers',
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
            'Elcodi\Component\Cart\Entity\Interfaces\CartInterface' => 'elcodi.core.cart.entity.cart.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderInterface' => 'elcodi.core.cart.entity.order.class',
            'Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface' => 'elcodi.core.cart.entity.cart_line.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface' => 'elcodi.core.cart.entity.order_line.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderHistoryInterface' => 'elcodi.core.cart.entity.order_history.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderLineHistoryInterface' => 'elcodi.core.cart.entity.order_line_history.class',
        ];
    }
}
