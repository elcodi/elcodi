<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  * @version
 */

namespace Elcodi\CurrencyBundle\Wrapper;

use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Exception\DefaultCurrencyNotFound;
use Elcodi\CurrencyBundle\Repository\CurrencyRepository;

/**
 * Class CurrencyWrapper
 */
class CurrencyWrapper
{
    /**
     * @var CurrencyRepository
     *
     * Currency Repository
     */
    protected $currencyRepository;

    /**
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrency;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    protected $currency;

    /**
     * Construct method
     *
     * @param CurrencyRepository $currencyRepository Currency Repository
     * @param string             $defaultCurrency       Currency
     */
    public function __construct(
        CurrencyRepository $currencyRepository,
        $defaultCurrency
    )
    {
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * Get currency
     *
     * @return CurrencyInterface Default currency
     *
     * @throws DefaultCurrencyNotFound
     */
    public function loadCurrency()
    {
        if ($this->currency instanceof CurrencyInterface) {

            return $this->currency;
        }

        $currency = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->defaultCurrency,
            ]);

        if (!($currency instanceof CurrencyInterface)) {

            throw new DefaultCurrencyNotFound;
        }

        $this->currency = $currency;

        return $currency;
    }

    /**
     * Get currency
     *
     * @return CurrencyInterface Default currency
     *
     * @throws DefaultCurrencyNotFound
     */
    public function reloadCurrency()
    {
        $this->currency = null;

        return $this->loadCurrency();
    }

    /**
     * Get currency loaded
     *
     * @return CurrencyInterface Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
 