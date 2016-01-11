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

namespace Elcodi\Component\Currency\Wrapper;

use Elcodi\Component\Core\Wrapper\Interfaces\WrapperInterface;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Exception\CurrencyNotAvailableException;
use Elcodi\Component\Currency\Repository\CurrencyRepository;
use Elcodi\Component\Currency\Services\CurrencySessionManager;

/**
 * Class CurrencyWrapper.
 */
class CurrencyWrapper implements WrapperInterface
{
    /**
     * @var CurrencySessionManager
     *
     * Currency Session Manager
     */
    private $currencySessionManager;

    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;

    /**
     * @var DefaultCurrencyWrapper
     *
     * Default currency wrapper
     */
    private $defaultCurrencyWrapper;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    private $currency;

    /**
     * Currency wrapper constructor.
     *
     * @param CurrencySessionManager $currencySessionManager Currency Session Manager
     * @param CurrencyRepository     $currencyRepository     Currency repository
     * @param DefaultCurrencyWrapper $defaultCurrencyWrapper Default currency wrapper
     */
    public function __construct(
        CurrencySessionManager $currencySessionManager,
        CurrencyRepository $currencyRepository,
        DefaultCurrencyWrapper $defaultCurrencyWrapper
    ) {
        $this->currencySessionManager = $currencySessionManager;
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrencyWrapper = $defaultCurrencyWrapper;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * The currency is loaded from session if exists. Otherwise will return the
     * default currency and saves it to session.
     *
     * @return CurrencyInterface Loaded object
     *
     * @throws CurrencyNotAvailableException No currency available
     */
    public function get()
    {
        if ($this->currency instanceof CurrencyInterface) {
            return $this->currency;
        }

        $this->currency = $this->loadCurrencyFromSession();

        if ($this->currency instanceof CurrencyInterface) {
            return $this->currency;
        }

        $this->currency = $this->loadDefaultCurrency();
        $this->saveCurrencyToSession($this->currency);

        return $this->currency;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        $this->currency = null;

        return $this;
    }

    /**
     * Load currency from session.
     *
     * @return CurrencyInterface|null Currency
     *
     * @throws CurrencyNotAvailableException No currency available
     */
    private function loadCurrencyFromSession()
    {
        $currencyIdInSession = $this
            ->currencySessionManager
            ->get();

        return $currencyIdInSession
            ? $this->currency = $this
                ->currencyRepository
                ->find($currencyIdInSession)
            : null;
    }

    /**
     * Save currency to session.
     *
     * @param CurrencyInterface $currency Currency
     *
     * @return $this Self object
     */
    private function saveCurrencyToSession(CurrencyInterface $currency)
    {
        $this
            ->currencySessionManager
            ->set($currency);

        return $this;
    }

    /**
     * Load default currency.
     *
     * @return CurrencyInterface Currency
     */
    private function loadDefaultCurrency()
    {
        return $this
            ->defaultCurrencyWrapper
            ->get();
    }
}
