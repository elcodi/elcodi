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

namespace Elcodi\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Elcodi\CurrencyBundle\Adapter\ExchangeRates\DummyExchangeRatesAdapter;
use Elcodi\CurrencyBundle\Adapter\ExchangeRates\OpenExchangeRatesAdapter;
use Elcodi\CurrencyBundle\Adapter\LocaleProvider\DummyLocaleProviderAdapter;
use Elcodi\CurrencyBundle\Adapter\LocaleProvider\ElcodiLocaleProviderAdapter;

/**
 * This is the class that loads and manages your bundle configuration
 */
class ElcodiCurrencyExtension extends AbstractExtension implements EntitiesOverridableExtensionInterface
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
            'elcodi.core.currency.default_currency' => $config['currency']['default_currency'],
            'elcodi.core.currency.session_field_name' => $config['currency']['session_field_name'],

            'elcodi.core.currency.rates_provider_currency_base' => $config['rates_provider']['currency_base'],
            'elcodi.core.currency.rates_provider_client' => $config['rates_provider']['client'],

            /**
             * OpenExchangeRates
             */
            'elcodi.core.currency.rates_provider_api_id' => $config['rates_provider'][OpenExchangeRatesAdapter::ADAPTER_NAME]['api_id'],
            'elcodi.core.currency.rates_provider_endpoint' => $config['rates_provider'][OpenExchangeRatesAdapter::ADAPTER_NAME]['endpoint'],
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
            'services',
            'factories',
            'twig',
            'repositories',
            'objectManagers',
            [
                'exchangeRatesAdapters/openExchangeRates',
                $config['rates_provider']['client'] === OpenExchangeRatesAdapter::ADAPTER_NAME
            ],
            [
                'exchangeRatesAdapters/dummyExchangeRates',
                $config['rates_provider']['client'] === DummyExchangeRatesAdapter::ADAPTER_NAME
            ],
            [
                'localeProvidersAdapters/elcodiLocaleProvider',
                $config['locale_provider']['adapter'] === ElcodiLocaleProviderAdapter::ADAPTER_NAME
            ],
            [
                'localeProvidersAdapters/dummyLocaleProvider',
                $config['locale_provider']['adapter'] === DummyLocaleProviderAdapter::ADAPTER_NAME
            ],
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
            'Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface' => 'elcodi.core.currency.entity.currency.class',
            'Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyExchangeRateInterface' => 'elcodi.core.currency.entity.currency_exchange_rate.class',
        ];
    }
}
