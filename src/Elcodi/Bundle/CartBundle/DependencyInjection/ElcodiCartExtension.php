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

namespace Elcodi\Bundle\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 */
class ElcodiCartExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_cart';

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
            'elcodi.entity.cart.class' => $config['mapping']['cart']['class'],
            'elcodi.entity.cart.mapping_file' => $config['mapping']['cart']['mapping_file'],
            'elcodi.entity.cart.manager' => $config['mapping']['cart']['manager'],
            'elcodi.entity.cart.enabled' => $config['mapping']['cart']['enabled'],

            'elcodi.entity.order.class' => $config['mapping']['order']['class'],
            'elcodi.entity.order.mapping_file' => $config['mapping']['order']['mapping_file'],
            'elcodi.entity.order.manager' => $config['mapping']['order']['manager'],
            'elcodi.entity.order.enabled' => $config['mapping']['order']['enabled'],

            'elcodi.entity.cart_line.class' => $config['mapping']['cart_line']['class'],
            'elcodi.entity.cart_line.mapping_file' => $config['mapping']['cart_line']['mapping_file'],
            'elcodi.entity.cart_line.manager' => $config['mapping']['cart_line']['manager'],
            'elcodi.entity.cart_line.enabled' => $config['mapping']['cart_line']['enabled'],

            'elcodi.entity.order_line.class' => $config['mapping']['order_line']['class'],
            'elcodi.entity.order_line.mapping_file' => $config['mapping']['order_line']['mapping_file'],
            'elcodi.entity.order_line.manager' => $config['mapping']['order_line']['manager'],
            'elcodi.entity.order_line.enabled' => $config['mapping']['order_line']['enabled'],

            'elcodi.cart_save_in_session' => $config['cart']['save_in_session'],
            'elcodi.cart_session_field_name' => $config['cart']['session_field_name'],

            'elcodi.order_payment_states_machine_states' => $config['payment_states_machine']['states'],
            'elcodi.order_payment_states_machine_identifier' => $config['payment_states_machine']['identifier'],
            'elcodi.order_payment_states_machine_point_of_entry' => $config['payment_states_machine']['point_of_entry'],

            'elcodi.order_shipping_states_machine_states' => $config['shipping_states_machine']['states'],
            'elcodi.order_shipping_states_machine_identifier' => $config['shipping_states_machine']['identifier'],
            'elcodi.order_shipping_states_machine_point_of_entry' => $config['shipping_states_machine']['point_of_entry'],
        ];
    }

    /**
     * Config files to load.
     *
     * @param array $config Config
     *
     * @return array Config files
     */
    public function getConfigFiles(array $config)
    {
        return [
            'eventListeners',
            'services',
            'wrappers',
            'factories',
            'repositories',
            'objectManagers',
            'directors',
            'transformers',
            'eventDispatchers',
            'stateMachine',
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
            'Elcodi\Component\Cart\Entity\Interfaces\CartInterface' => 'elcodi.entity.cart.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderInterface' => 'elcodi.entity.order.class',
            'Elcodi\Component\Cart\Entity\Interfaces\CartLineInterface' => 'elcodi.entity.cart_line.class',
            'Elcodi\Component\Cart\Entity\Interfaces\OrderLineInterface' => 'elcodi.entity.order_line.class',
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
