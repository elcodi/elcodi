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

namespace Elcodi\Component\Currency\Twig;

use NumberFormatter;
use Twig_Extension;
use Twig_SimpleFilter;

use Elcodi\Component\Currency\Adapter\LocaleProvider\Interfaces\LocaleProviderAdapterInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Exception\CurrencyNotAvailableException;
use Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException;
use Elcodi\Component\Currency\Services\CurrencyConverter;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;

/**
 * Print price extension for twig
 */
class PrintMoneyExtension extends Twig_Extension
{
    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    protected $currencyConverter;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    protected $currencyWrapper;

    /**
     * @var LocaleProviderAdapterInterface
     *
     * LocaleProvider adapter
     */
    protected $localeProviderAdapter;

    /**
     * Construct method
     *
     * @param CurrencyConverter              $currencyConverter     Currency converter
     * @param CurrencyWrapper                $currencyWrapper       Currency wrapper
     * @param LocaleProviderAdapterInterface $localeProviderAdapter LocaleProvider adapter
     */
    public function __construct(
        CurrencyConverter $currencyConverter,
        CurrencyWrapper $currencyWrapper,
        LocaleProviderAdapterInterface $localeProviderAdapter
    )
    {
        $this->currencyConverter = $currencyConverter;
        $this->currencyWrapper = $currencyWrapper;
        $this->localeProviderAdapter = $localeProviderAdapter;
    }

    /**
     * Return all filters
     *
     * @return Twig_SimpleFilter[] Filters
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('print_convert_money', array($this, 'printConvertMoney')),
            new Twig_SimpleFilter('print_money', array($this, 'printMoney')),
        );
    }

    /**
     * Return a formatted price given an Money object and the target currency
     *
     * If money is null, print empty string
     *
     * @param MoneyInterface    $money          the Money object to print
     * @param CurrencyInterface $targetCurrency Iso code of the target currency (optional)
     *
     * @throws CurrencyNotAvailableException   Any currency available
     * @throws CurrencyNotConvertibleException Currencies cannot be converted
     *
     * @return string The formatted price
     */
    public function printConvertMoney(
        MoneyInterface $money = null,
        CurrencyInterface $targetCurrency = null
    )
    {
        if (!($money instanceof MoneyInterface)) {
            return '';
        }

        if (!($targetCurrency instanceof CurrencyInterface)) {

            $targetCurrency = $this->currencyWrapper->loadCurrency();
        }

        $moneyConverted = $this
            ->currencyConverter
            ->convertMoney(
                $money,
                $targetCurrency
            );

        return $this->printMoney($moneyConverted);
    }

    /**
     * Return a formatted price given an Money object
     *
     * If money is null, print empty string
     *
     * @param MoneyInterface $money the Money object to print
     *
     * @return string The formatted price
     */
    public function printMoney(MoneyInterface $money = null)
    {
        if (!($money instanceof MoneyInterface)) {
            return '';
        }

        if (!($money->getCurrency() instanceof CurrencyInterface)) {
            return $money->getAmount();
        }

        $formatter = new NumberFormatter(
            $this->localeProviderAdapter->getLocaleIso(),
            NumberFormatter::CURRENCY
        );

        $formatter->setSymbol(
            NumberFormatter::CURRENCY_SYMBOL,
            $money->getCurrency()->getSymbol()
        );

        /**
         * The precision of the integer amount for a given Money
         * (cents, thousandths, 10-thousandths, etc) should be
         * stored in the Currency object. We assume amounts are
         * represented in cents
         *
         * Loss of precision due to conversion is possible, but only when
         * displaying prices. This operation does not affect amounts
         */

        return $formatter->format($money->getAmount() / 100);
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
