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

namespace Elcodi\Component\Currency\Services;

use NumberFormatter;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Interfaces\MoneyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Currency\Exception\CurrencyNotAvailableException;
use Elcodi\Component\Currency\Exception\CurrencyNotConvertibleException;
use Elcodi\Component\Currency\Wrapper\CurrencyWrapper;
use Elcodi\Component\Language\Entity\Interfaces\LocaleInterface;

/**
 * Class MoneyPrinter.
 *
 * This service provides a different ways for Money print
 */
class MoneyPrinter
{
    /**
     * @var CurrencyConverter
     *
     * Currency converter
     */
    private $currencyConverter;

    /**
     * @var CurrencyWrapper
     *
     * Currency Wrapper
     */
    private $currencyWrapper;

    /**
     * @var LocaleInterface
     *
     * Locale
     */
    private $locale;

    /**
     * Construct method.
     *
     * @param CurrencyConverter $currencyConverter Currency converter
     * @param CurrencyWrapper   $currencyWrapper   Currency wrapper
     * @param LocaleInterface   $locale            Locale iso
     */
    public function __construct(
        CurrencyConverter $currencyConverter,
        CurrencyWrapper $currencyWrapper,
        LocaleInterface $locale
    ) {
        $this->currencyConverter = $currencyConverter;
        $this->currencyWrapper = $currencyWrapper;
        $this->locale = $locale;
    }

    /**
     * Return a formatted price given an Money object and the target currency.
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
    ) {
        if (!($money instanceof MoneyInterface)) {
            return '';
        }

        if (!($targetCurrency instanceof CurrencyInterface)) {
            $targetCurrency = $this
                ->currencyWrapper
                ->get();
        }

        /**
         * @var CurrencyInterface $targetCurrency
         */
        $moneyConverted = $this
            ->currencyConverter
            ->convertMoney(
                $money,
                $targetCurrency
            );

        return $this->printMoney($moneyConverted);
    }

    /**
     * Return a formatted price given an Money object.
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

        $moneyFormatter = new NumberFormatter(
            $this->locale->getIso(),
            NumberFormatter::CURRENCY
        );

        /**
         * The precision of the integer amount for a given Money
         * (cents, thousandths, 10-thousandths, etc) should be
         * stored in the Currency object. We assume amounts are
         * represented in cents.
         *
         * Loss of precision due to conversion is possible, but only when
         * displaying prices. This operation does not affect amounts
         */

        return $moneyFormatter
            ->formatCurrency(
                $money->getAmount() / 100,
                $money->getCurrency()->getIso()
            );
    }

    /**
     * Return a formatted price given the price in an integer format.
     *
     * Takes the currency from CurrencyWrapper
     *
     * @param int $value Value
     *
     * @return string The formatted price
     */
    public function printMoneyFromValue($value)
    {
        $targetCurrency = $this
            ->currencyWrapper
            ->get();

        $money = Money::create(
            $value,
            $targetCurrency
        );

        return $this->printMoney($money);
    }
}
