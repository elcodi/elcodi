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

namespace Elcodi\CurrencyBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use NumberFormatter;

/**
 * Print price extension for twig
 */
class PrintPriceExtension extends Twig_Extension
{
    /**
     * @var array
     *
     * An array with currencyExchange rates
     */
    protected $currencyExchangeRates;

    /**
     * @var array
     *
     * An array with the currency symbols
     */
    protected $currencySymbols;

    /**
     * Construct method
     *
     * @param array  $currencyExchangeRates list of exchange rates
     * @param array  $currencySymbols       list of currency symbols
     * @param string $locale                The locale
     */
    public function __construct(
        array $currencyExchangeRates,
        array $currencySymbols,
        $locale
    )
    {
        $this->currencyExchangeRates = $currencyExchangeRates;
        $this->currencySymbols = $currencySymbols;
        $this->locale = $locale;
    }

    /**
     * Return all filters
     *
     * @return array Filters created
     */
    public function getFilters()
    {
        return array(
            'print_price' => new Twig_Filter_Method($this, 'printPrice'),
        );
    }

    /**
     * Return a formatted price given an amount and the target currency
     *
     * @param float  $amount         the amount to print
     * @param string $sourceCurrency Iso code of the source currency
     * @param string $targetCurrency Iso code of the target currency
     *
     * @throws \Exception if source-target exchange is missing
     *
     * @return string The formatted price
     */
    public function printPrice($amount, $sourceCurrency, $targetCurrency)
    {
        if (isset($this->currencyExchangeRates[$sourceCurrency])
            && isset($this->currencyExchangeRates[$sourceCurrency][$targetCurrency])
        ) {
            $currencyRate = $this->currencyExchangeRates[$sourceCurrency][$targetCurrency];
        }

        if ($sourceCurrency == $targetCurrency) {
            $currencyRate = 1.0;
        }

        if (!isset($currencyRate)) {
            throw new \Exception('This exchange is not possible');
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $targetCurrencySymbol = $this->currencySymbols[$targetCurrency];
        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, $targetCurrencySymbol);

        return $formatter->format($amount * $currencyRate);
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'print_price_extension';
    }
}
