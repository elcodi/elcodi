<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\CurrencyBundle\Twig;

use Elcodi\CurrencyBundle\Entity\Interfaces\MoneyInterface;
use Twig_Extension;
use Twig_Filter_Method;
use NumberFormatter;

/**
 * Print price extension for twig
 */
class PrintMoneyExtension extends Twig_Extension
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
            'print_money' => new Twig_Filter_Method($this, 'printMoney'),
        );
    }

    /**
     * Return a formatted price given an Money object and the target currency
     *
     * @param MoneyInterface $money          the Money object to print
     * @param string         $targetCurrency Iso code of the target currency (optional)
     *
     * @throws \Exception if source-target exchange is missing
     *
     * @return string The formatted price
     */
    public function printMoney($money, $targetCurrency = null)
    {
        $sourceCurrency = $money->getCurrency()->getIso();

        if (is_null($targetCurrency) || $sourceCurrency == $targetCurrency) {

            $currencyRate = 1.0;

            /* Covering the case of $targetCurrency being null */
            $targetCurrency = $sourceCurrency;

        } elseif (isset($this->currencyExchangeRates[$sourceCurrency])
               && isset($this->currencyExchangeRates[$sourceCurrency][$targetCurrency])) {

            $currencyRate = $this->currencyExchangeRates[$sourceCurrency][$targetCurrency];

        } else {
            /* No CurrencyRate can be found */
            throw new \Exception('Currency Rate not found. Exchange conversion not possible');
        }

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);
        $targetCurrencySymbol = $this->currencySymbols[$targetCurrency];
        $formatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, $targetCurrencySymbol);

        /* The precision of the integer amount for a given Money
         * (cents, thousandths, 10-thousandths, etc) should be
         * stored in the Currency object. We assume amounts are
         * represented in cents */
        $amount = $money->getAmount() / 100;

        /* Loss of precision due to conversion is possible, but only when
         * displaying prices. This operation does not affect amounts */

        return $formatter->format($amount * $currencyRate);
    }

    /**
     * return extension name
     *
     * @return string extension name
     */
    public function getName()
    {
        return 'print_money_extension';
    }
}
