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

namespace Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider;

use GuzzleHttp\Client;

use Elcodi\Component\Currency\Adapter\CurrencyExchangeRatesProvider\Interfaces\CurrencyExchangeRatesProviderAdapterInterface;

/**
 * Class YahooFinanceProviderAdapter.
 */
class YahooFinanceProviderAdapter implements CurrencyExchangeRatesProviderAdapterInterface
{
    /**
     * @var Client
     *
     * Client
     */
    private $client;

    /**
     * Service constructor.
     *
     * @param Client $client Guzzle client for requests
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the latest exchange rates.
     *
     * This method will take in account always that the base currency is USD,
     * and the result must complain this format.
     *
     * [
     *      "EUR" => "1,78342784",
     *      "YEN" => "0,67438268",
     *      ...
     * ]
     *
     * @return array exchange rates
     */
    public function getExchangeRates()
    {
        $exchangeRates = [];
        $response = $this
            ->client
            ->get(
                'http://finance.yahoo.com/webservice/v1/symbols/allcurrencies/quote',
                [
                    'query' => [
                        'format' => 'json',
                    ],
                ]
            )
            ->json();

        foreach ($response['list']['resources'] as $resource) {
            $fields = $resource['resource']['fields'];
            $symbol = str_replace('=X', '', $fields['symbol']);
            $exchangeRates[$symbol] = (float) $fields['price'];
        }

        return $exchangeRates;
    }
}
