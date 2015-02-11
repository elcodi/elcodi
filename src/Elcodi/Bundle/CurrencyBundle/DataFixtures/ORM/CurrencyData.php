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

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Currency\Factory\CurrencyFactory;

/**
 * Class CurrencyData
 */
class CurrencyData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CurrencyFactory $currencyFactory
         */
        $currencyFactory = $this->getFactory('currency');
        $currencyObjectManager = $this->getObjectManager('currency');

        /**
         * Dollar
         */
        $currencyDollar = $currencyFactory
            ->create()
            ->setName('Dollar')
            ->setSymbol('$')
            ->setIso('USD');

        $currencyObjectManager->persist($currencyDollar);
        $this->setReference('currency-dollar', $currencyDollar);

        /**Euro
         */
        $currencyEuro = $currencyFactory
            ->create()
            ->setName('Euro')
            ->setSymbol('€')
            ->setIso('EUR');

        $currencyObjectManager->persist($currencyEuro);
        $this->setReference('currency-euro', $currencyEuro);

        /**
         * Pound
         */
        $currencyPound = $currencyFactory
            ->create()
            ->setName('Pound')
            ->setSymbol('£')
            ->setIso('GBP');

        $currencyObjectManager->persist($currencyPound);
        $this->setReference('currency-pound', $currencyPound);

        /**
         * Ien
         */
        $currencyIen = $currencyFactory
            ->create()
            ->setName('Yen')
            ->setSymbol('円')
            ->setIso('JPY');

        $currencyObjectManager->persist($currencyIen);
        $this->setReference('currency-ien', $currencyIen);

        $currencyObjectManager->flush([
            $currencyDollar,
            $currencyEuro,
            $currencyPound,
            $currencyIen,
        ]);
    }
}
