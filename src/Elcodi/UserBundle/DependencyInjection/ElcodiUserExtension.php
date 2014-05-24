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

namespace Elcodi\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This class loads and manages your bundle configuration
 */
class ElcodiUserExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
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
            'elcodi.core.user.session_field_name' => $config['session_field_name'],
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
            'formTypes',
            'services',
            'eventListeners',
            'factories',
            'repositories',
        ];
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return [
            'Elcodi\UserBundle\Entity\Interfaces\CustomerInterface' => 'elcodi.core.user.entity.customer.class',
            'Elcodi\UserBundle\Entity\Interfaces\AddressInterface' => 'elcodi.core.user.entity.address.class',
            'Elcodi\CartBundle\Entity\Interfaces\CartInterface' => 'elcodi.core.cart.entity.cart.class',
            'Elcodi\CartBundle\Entity\Interfaces\OrderInterface' => 'elcodi.core.cart.entity.order.class'
        ];
    }
}
