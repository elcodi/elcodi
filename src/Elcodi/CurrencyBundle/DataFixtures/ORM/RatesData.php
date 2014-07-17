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

namespace Elcodi\CurrencyBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyExchangeRateInterface;
use Elcodi\CurrencyBundle\Entity\Interfaces\CurrencyInterface;
use Elcodi\CurrencyBundle\Factory\CurrencyExchangeRateFactory;

/**
 * Class RatesData
 */
class RatesData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CurrencyExchangeRateFactory $currencyExchangeRateFactory
         * @var CurrencyInterface           $currencyEuro
         * @var CurrencyInterface           $currencyDollar
         * @var CurrencyInterface           $currencyPound
         * @var CurrencyInterface           $currencyIen
         */
        $currencyExchangeRateFactory = $this
            ->container
            ->get('elcodi.factory.currency_exchange_rate');

        $currencyEuro = $this->getReference('currency-euro');
        $currencyDollar = $this->getReference('currency-dollar');
        $currencyPound = $this->getReference('currency-pound');
        $currencyIen = $this->getReference('currency-ien');

        /**
         * @var CurrencyExchangeRateInterface $dollarToEuroRate
         */
        $dollarToEuroRate = $currencyExchangeRateFactory->create();
        $dollarToEuroRate
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyEuro)
            ->setExchangeRate(0.736596);
        $manager->persist($dollarToEuroRate);

        /**
         * @var CurrencyExchangeRateInterface $dollarToPoundRate
         */
        $dollarToPoundRate = $currencyExchangeRateFactory->create();
        $dollarToPoundRate
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyPound)
            ->setExchangeRate(0.588765);
        $manager->persist($dollarToPoundRate);

        /**
         * @var CurrencyExchangeRateInterface $dollarToIenRate
         */
        $dollarToIenRate = $currencyExchangeRateFactory->create();
        $dollarToIenRate
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyIen)
            ->setExchangeRate(101.822625);
        $manager->persist($dollarToIenRate);

        $manager->flush();
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
