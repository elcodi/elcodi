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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Message\RequestInterface;

use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces\CurrencyExchangeRatesProviderAdapterInterface;

/**
 * Class OpenExchangeRatesProviderAdapter
 *
 * @author Gonzalo Miguez <mrzard@gmail.com>
 */
class OpenExchangeRatesProviderAdapter implements CurrencyExchangeRatesProviderAdapterInterface
{
    /**
     * @var Client
     *
     * Client
     */
    protected $client;

    /**
     * @var string
     *
     * the app id
     */
    protected $appId;

    /**
     * @var string
     *
     * the api endpoint
     */
    protected $endPoint;

    /**
     * @var string
     *
     * base currency
     */
    protected $baseCurrency;

    /**
     * Service constructor
     *
     * @param Client $client                 Guzzle client for requests
     * @param string $openExchangeRatesAppId the app_id for OpenExchangeRates
     * @param string $endPoint               Endpoint
     * @param string $baseCurrency           Base currency
     */
    public function __construct(
        Client $client,
        $openExchangeRatesAppId,
        $endPoint,
        $baseCurrency
    )
    {
        $this->client = $client;
        $this->appId = $openExchangeRatesAppId;
        $this->endPoint = $endPoint;
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * Converts $value from currency $symbolFrom to currency $symbolTo
     *
     * @param float  $value      value to convert
     * @param string $symbolFrom symbol to convert from
     * @param string $symbolTo   symbol to convert to
     *
     * @return float
     */
    public function convertCurrency($value, $symbolFrom, $symbolTo)
    {
        $query = ['app_id' => $this->appId];

        $request = $this->client->createRequest(
            'GET',
            $this->endPoint . '/convert/' . $value . '/' . $symbolFrom . '/' . $symbolTo,
            ['query' => $query]
        );

        return $this->runRequest($request);
    }

    /**
     * Get the latest exchange rates
     *
     * @param array  $symbols array of currency codes to get the rates for.
     *                        Default empty (all currencies)
     * @param string $base    Base currency, default NULL (gets it from config)
     *
     * @return array
     */
    public function getExchangeRates(array $symbols = array(), $base = null)
    {
        $query = [
            'app_id' => $this->appId,
            'base'   => is_null($base) ? $this->baseCurrency : $base
        ];

        if (count($symbols)) {
            $query['symbols'] = implode(',', $symbols);
        }

        $request = $this->client->createRequest(
            'GET',
            $this->endPoint . '/latest.json',
            ['query' => $query]
        );

        return $this->runRequest($request)['rates'];
    }

    /**
     * Gets a list of all available currencies
     */
    public function getCurrencies()
    {
        $request = $this->client->createRequest(
            'GET',
            $this->endPoint . '/currencies.json',
            ['query' => ['app_id' => $this->appId]]
        );

        return $this->runRequest($request);
    }

    /**
     * Run guzzle request
     *
     * @param RequestInterface $request
     *
     * @return array
     */
    private function runRequest(RequestInterface $request)
    {
        try {
            $response = $this->client->send($request);

            //send the req and return the json
            return $response->json();
        } catch (Exception $e) {
            return array('error' => $request->getResponse()->json());
        }
    }

    /**
     * Get historical data
     *
     * @param \DateTime $date
     *
     * @return array
     */
    public function getHistorical(DateTime $date)
    {
        $request = $this->client->createRequest(
            'GET',
            $this->endPoint . '/historical/' . $date->format('Y-m-d') . '.json',
            [
                'query' =>
                    [
                        'app_id' => $this->appId,
                        'base'   => $this->baseCurrency
                    ]
            ]
        );

        return $this->runRequest($request);
    }
}
