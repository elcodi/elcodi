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

/**
 * Class DefaultCurrencyWrapper.
 */
class DefaultCurrencyWrapper implements WrapperInterface
{
    /**
     * @var CurrencyRepository
     *
     * Currency repository
     */
    private $currencyRepository;

    /**
     * @var string
     *
     * Default currency
     */
    private $defaultCurrencyIsoCode;

    /**
     * Currency wrapper constructor.
     *
     * @param CurrencyRepository $currencyRepository     Currency repository
     * @param string             $defaultCurrencyIsoCode Default currency
     */
    public function __construct(
        CurrencyRepository $currencyRepository,
        $defaultCurrencyIsoCode
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->defaultCurrencyIsoCode = $defaultCurrencyIsoCode;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * Returns the default persisted Currency object
     *
     * The currency object is fetched from the repository using
     * default ISO code as the search criteria. Default ISO code
     * is passed to the CurrencyWrapper service definition as a
     * mandatory constructor parameter.
     *
     * @return CurrencyInterface Default currency
     *
     * @throws CurrencyNotAvailableException Currency not available
     */
    public function get()
    {
        $currency = $this
            ->currencyRepository
            ->findOneBy([
                'iso' => $this->defaultCurrencyIsoCode,
            ]);

        if (!($currency instanceof CurrencyInterface)) {
            throw new CurrencyNotAvailableException(
                sprintf('Default currency object for ISO code "%s" not found', $this->defaultCurrencyIsoCode)
            );
        }

        return $currency;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return $this Self object
     */
    public function clean()
    {
        return $this;
    }
}
