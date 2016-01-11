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

namespace Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;

/**
 * Class CurrencyExchangeRatesData.
 */
class CurrencyExchangeRatesData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector    $currencyExchangeRateDirector
         * @var CurrencyInterface $currencyEuro
         * @var CurrencyInterface $currencyDollar
         * @var CurrencyInterface $currencyPound
         * @var CurrencyInterface $currencyIen
         */
        $currencyExchangeRateDirector = $this->getDirector('currency_exchange_rate');
        $currencyEuro = $this->getReference('currency-euro');
        $currencyDollar = $this->getReference('currency-dollar');
        $currencyPound = $this->getReference('currency-pound');
        $currencyIen = $this->getReference('currency-ien');

        /**
         * Dollar to Euro.
         */
        $dollarToEuroRate = $currencyExchangeRateDirector
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyEuro)
            ->setExchangeRate(0.736596);

        $currencyExchangeRateDirector->save($dollarToEuroRate);

        /**
         * Dollar to Pound.
         */
        $dollarToPoundRate = $currencyExchangeRateDirector
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyPound)
            ->setExchangeRate(0.588765);

        $currencyExchangeRateDirector->save($dollarToPoundRate);

        /**
         * Dollar to Yen.
         */
        $dollarToIenRate = $currencyExchangeRateDirector
            ->create()
            ->setSourceCurrency($currencyDollar)
            ->setTargetCurrency($currencyIen)
            ->setExchangeRate(101.822625);

        $currencyExchangeRateDirector->save($dollarToIenRate);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
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
