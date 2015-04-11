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

namespace Elcodi\Bundle\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiCurrencyExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
{
    /**
     * @var string
     *
     * Extension name
     */
    const EXTENSION_NAME = 'elcodi_currency';

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
        $result = [
            "elcodi.entity.currency.class"                      => $config['mapping']['currency']['class'],
            "elcodi.entity.currency.mapping_file"               => $config['mapping']['currency']['mapping_file'],
            "elcodi.entity.currency.manager"                    => $config['mapping']['currency']['manager'],
            "elcodi.entity.currency.enabled"                    => $config['mapping']['currency']['enabled'],

            "elcodi.entity.currency_exchange_rate.class"        => $config['mapping']['currency_exchange_rate']['class'],
            "elcodi.entity.currency_exchange_rate.mapping_file" => $config['mapping']['currency_exchange_rate']['mapping_file'],
            "elcodi.entity.currency_exchange_rate.manager"      => $config['mapping']['currency_exchange_rate']['manager'],
            "elcodi.entity.currency_exchange_rate.enabled"      => $config['mapping']['currency_exchange_rate']['enabled'],

            'elcodi.core.currency.default_currency'             => $config['currency']['default_currency'],
            'elcodi.core.currency.session_field_name'           => $config['currency']['session_field_name'],

            'elcodi.core.currency.rates_provider_currency_base' => $config['rates_provider']['currency_base'],
            'elcodi.core.currency.rates_provider_client'        => $config['rates_provider']['client'],
        ];

        /**
         * OpenExchangeRates
         */
        if ($config['rates_provider']['open_exchange_rates']) {
            $result['elcodi.core.currency.rates_provider_api_id'] = $config['rates_provider']['open_exchange_rates']['api_id'];
            $result['elcodi.core.currency.rates_provider_endpoint'] = $config['rates_provider']['open_exchange_rates']['endpoint'];
        }

        return $result;
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
            'commands',
            'currencyExchangeRatesProviderAdapters',
            'expressionLanguage',
            'factories',
            'objectManagers',
            'repositories',
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
            'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface'             => 'elcodi.entity.currency.class',
            'Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface' => 'elcodi.entity.currency_exchange_rate.class',
        ];
    }

    /**
     * Post load implementation
     *
     * @param array            $config    Parsed configuration
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    protected function postLoad(array $config, ContainerBuilder $container)
    {
        parent::postLoad($config, $container);

        $ratesProviderId = $config['rates_provider']['client'];
        $container->setAlias('elcodi.adapter.currency_exchange_rate', $ratesProviderId);
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
