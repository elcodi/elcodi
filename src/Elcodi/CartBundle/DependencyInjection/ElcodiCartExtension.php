<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CartBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

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
            'elcodi.core.cart.order_states' => $config['order']['states'],
            'elcodi.core.cart.order_initial_state' => $config['order']['initial_state'],
            'elcodi.core.cart.session_field_name' => $config['cart']['session_field_name']
        ];
    }

    /**
     * Config files to load
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return [
            'classes',
            'eventListeners',
            'services',
            'factories',
            'repositories',
            'managers',
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
            'Elcodi\CartBundle\Entity\Interfaces\CartInterface' => 'elcodi.core.cart.entity.cart.class',
            'Elcodi\CartBundle\Entity\Interfaces\OrderInterface' => 'elcodi.core.cart.entity.order.class',
            'Elcodi\CartBundle\Entity\Interfaces\CartLineInterface' => 'elcodi.core.cart.entity.cart_line.class',
            'Elcodi\CartBundle\Entity\Interfaces\OrderLineInterface' => 'elcodi.core.cart.entity.order_line.class',
            'Elcodi\CartBundle\Entity\Interfaces\OrderHistoryInterface' => 'elcodi.core.cart.entity.order_history.class',
            'Elcodi\CartBundle\Entity\Interfaces\OrderLineHistoryInterface' => 'elcodi.core.cart.entity.order_line_history.class',
        ];
    }
}
