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

namespace Elcodi\Bundle\CurrencyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;

use Elcodi\Bundle\CoreBundle\DependencyInjection\Abstracts\AbstractExtension;
use Elcodi\Bundle\CoreBundle\DependencyInjection\Interfaces\EntitiesOverridableExtensionInterface;
use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\DummyProviderAdapter as DummyCurrencyExchangeRatesProviderAdapter;
use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\OpenExchangeRatesProviderAdapter;
use Elcodi\Component\Currency\Adapter\LocaleProvider\DummyProviderAdapter as DummyLocaleProviderAdapter;
use Elcodi\Component\Currency\Adapter\LocaleProvider\ElcodiProviderAdapter;

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
    public static function getExtensionName()
    {
        return 'elcodi_currency';
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
            "elcodi.core.currency.entity.currency.class" => $config['mapping']['currency']['class'],
            "elcodi.core.currency.entity.currency.mapping_file" => $config['mapping']['currency']['mapping_file'],
            "elcodi.core.currency.entity.currency.manager" => $config['mapping']['currency']['manager'],
            "elcodi.core.currency.entity.currency.enabled" => $config['mapping']['currency']['enabled'],

            "elcodi.core.currency.entity.currency_exchange_rate.class" => $config['mapping']['currency_exchange_rate']['class'],
            "elcodi.core.currency.entity.currency_exchange_rate.mapping_file" => $config['mapping']['currency_exchange_rate']['mapping_file'],
            "elcodi.core.currency.entity.currency_exchange_rate.manager" => $config['mapping']['currency_exchange_rate']['manager'],
            "elcodi.core.currency.entity.currency_exchange_rate.enabled" => $config['mapping']['currency_exchange_rate']['enabled'],

            'elcodi.core.currency.default_currency' => $config['currency']['default_currency'],
            'elcodi.core.currency.session_field_name' => $config['currency']['session_field_name'],

            'elcodi.core.currency.rates_provider_currency_base' => $config['rates_provider']['currency_base'],
            'elcodi.core.currency.rates_provider_client' => $config['rates_provider']['client'],

            /**
             * OpenExchangeRates
             */
            'elcodi.core.currency.rates_provider_api_id' => $config['rates_provider'][OpenExchangeRatesProviderAdapter::ADAPTER_NAME]['api_id'],
            'elcodi.core.currency.rates_provider_endpoint' => $config['rates_provider'][OpenExchangeRatesProviderAdapter::ADAPTER_NAME]['endpoint'],
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
            'commands',
            [
                'currencyExchangeRatesProviderAdapters/openExchangeRatesProviderAdapter',
                $config['rates_provider']['client'] === OpenExchangeRatesProviderAdapter::ADAPTER_NAME
            ],
            [
                'currencyExchangeRatesProviderAdapters/dummyProviderAdapter',
                $config['rates_provider']['client'] === DummyCurrencyExchangeRatesProviderAdapter::ADAPTER_NAME
            ],
            [
                'localeProviderAdapters/elcodiLocaleProvider',
                $config['locale_provider']['adapter'] === ElcodiProviderAdapter::ADAPTER_NAME
            ],
            [
                'localeProviderAdapters/dummyLocaleProvider',
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
            'Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface' => 'elcodi.core.currency.entity.currency.class',
            'Elcodi\Component\Currency\Entity\Interfaces\CurrencyExchangeRateInterface' => 'elcodi.core.currency.entity.currency_exchange_rate.class',
        ];
    }
}
