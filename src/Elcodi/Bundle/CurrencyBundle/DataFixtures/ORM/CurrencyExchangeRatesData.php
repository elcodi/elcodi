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

namespace Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Factory\CurrencyExchangeRateFactory;

/**
 * Class CurrencyExchangeRatesData
 */
class CurrencyExchangeRatesData extends AbstractFixture implements DependentFixtureInterface
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
        $currencyExchangeRateFactory = $this->getFactory('currency_exchange_rate');
        $currencyExchangeRateObjectManager = $this->getObjectManager('currency_exchange_rate');
        $currencyEuro = $this->getReference('currency-euro');
        $currencyDollar = $this->getReference('currency-dollar');
        $currencyPound = $this->getReference('currency-pound');
        $currencyIen = $this->getReference('currency-ien');

        /**
         * Dollar to Euro
         */
        $dollarToEuroRate = $currencyExchangeRateFactory
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyEuro)
            ->setExchangeRate(0.736596);

        $currencyExchangeRateObjectManager->persist($dollarToEuroRate);

        /**
         * Dollar to Pound
         */
        $dollarToPoundRate = $currencyExchangeRateFactory
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyPound)
            ->setExchangeRate(0.588765);

        $currencyExchangeRateObjectManager->persist($dollarToPoundRate);

        /**
         * Dollar to Yen
         */
        $dollarToIenRate = $currencyExchangeRateFactory
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyIen)
            ->setExchangeRate(101.822625);

        $currencyExchangeRateObjectManager->persist($dollarToIenRate);

        $manager->flush([
            $dollarToEuroRate,
            $dollarToPoundRate,
            $dollarToIenRate
        ]);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
        ];
    }
}
