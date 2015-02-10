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

namespace Elcodi\Component\Currency\Wrapper;

use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Exception\CurrencyNotAvailableException;
use Elcodi\Component\Currency\Repository\CurrencyRepository;
use Elcodi\Component\Currency\Services\CurrencySessionManager;

/**
 * Class CurrencyWrapper
 */
class CurrencyWrapper
{
    /**
     * @var CurrencySessionManager
     *
     * Currency Session Manager
     */
    protected $currencySessionManager;

    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    protected $currencyRepository;

    /**
     * @var string
     *
     * Default currency
     */
    protected $defaultCurrencyIsoCode;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    protected $currency;

    /**
     * Currency wrapper constructor
     *
     * @param CurrencySessionManager $currencySessionManager Currency Session Manager
     * @param CurrencyRepository     $currencyRepository     Currency repository
     * @param string                 $defaultCurrencyIsoCode Default currency
     */
    public function __construct(
        CurrencySessionManager $currencySessionManager,
        CurrencyRepository $currencyRepository,
        $defaultCurrencyIsoCode
    )
    {
        $this->currencySessionManager = $currencySessionManager;
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrencyIsoCode = $defaultCurrencyIsoCode;
    }

    /**
     * Gets Currency
     *
     * @return CurrencyInterface Instance of Cart loaded
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Loads Currency from session or repository
     *
     * @return CurrencyInterface Instance of Customer loaded
     *
     * @throws CurrencyNotAvailableException Any currency available
     */
    public function loadCurrency()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return $this->currency;
        }

        $currencyIdInSession = $this->currencySessionManager->get();

        /**
         * Tries to load currency saved in session
         */
        if ($currencyIdInSession) {

            $this->currency = $this
                ->currencyRepository
                ->find($currencyIdInSession);
        }

        if ($this->currency instanceof CurrencyInterface) {
            return $this->currency;
        }

        /**
         * Otherwise, tries to load default currency. Notice that default
         * currency is defined as parameter
         */
        $this->currency = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->defaultCurrencyIsoCode,
            ]);

        if ($this->currency instanceof CurrencyInterface) {

            $this->currencySessionManager->set($this->currency);

            return $this->currency;
        }

        throw new CurrencyNotAvailableException();
    }

    /**
     * Returns the default persisted Currency object
     *
     * The currency object is fetched from the repository using
     * default ISO code as the search criteria. Default ISO code
     * is passed to the CurrencyWrapper service definition as a
     * mandatory constructor parameter.
     *
     * When the object is not found, a LogicException is thrown
     *
     * @return CurrencyInterface
     *
     * @throws \LogicException
     */
    public function getDefaultCurrency()
    {
        $defaultCurrency = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->defaultCurrencyIsoCode,
            ]);

        if (!($defaultCurrency instanceof CurrencyInterface)) {

            throw new \LogicException(
                sprintf('Default currency object for ISO code "%s" not found', $this->defaultCurrencyIsoCode)
            );
        }

        return $defaultCurrency;
    }

    /**
     * Reload cart
     *
     * This method sets to null current cart and tries to load it again
     *
     * @return CurrencyInterface Currency re-loaded
     */
    public function reloadCurrency()
    {
        $this->currency = null;

        return $this->loadCurrency();
    }
}
