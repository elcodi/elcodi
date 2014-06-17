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

namespace Elcodi\CurrencyBundle\Wrapper;

use Elcodi\CurrencyBundle\Services\CurrencySessionManager;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Exception\CurrencyNotAvailableException;
use Elcodi\CurrencyBundle\Repository\CurrencyRepository;

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
    protected $defaultCurrency;

    /**
     * @var CurrencyInterface
     *
     * Currency
     */
    protected $currency;

    /**
     * construct method
     *
     * @param CurrencySessionManager $currencySessionManager Currency Session Manager
     * @param CurrencyRepository     $currencyRepository     Currency repository
     * @param string                 $defaultCurrency        Default currency
     */
    public function __construct(
        CurrencySessionManager $currencySessionManager,
        CurrencyRepository $currencyRepository,
        $defaultCurrency
    )
    {
        $this->currencySessionManager = $currencySessionManager;
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * Get cart
     *
     * Return current currency value
     *
     * @return CurrencyInterface Instance of Cart loaded
     *
     * @api
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Load cart
     *
     * This method, first of all tries to retrieve cart from session
     *
     * If this does not exists nor the id is not valid, a new cart is created
     * using Cart factory
     *
     * This behavior can be overriden just overwritting the wrapper
     *
     * @return CurrencyInterface Instance of Customer loaded
     *
     * @throws CurrencyNotAvailableException Any currency available
     *
     * @api
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
                'iso' => $this->defaultCurrency,
            ]);

        if ($this->currency instanceof CurrencyInterface) {

            $this->currencySessionManager->set($this->currency);

            return $this->currency;
        }

        throw new CurrencyNotAvailableException;
    }

    /**
     * Reload cart
     *
     * This method sets to null current cart and tries to load it again
     *
     * @return CurrencyInterface Currency re-loaded
     *
     * @api
     */
    public function reloadCurrency()
    {
        $this->currency = null;

        return $this->loadCurrency();
    }
}
