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

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class CurrencyData.
 */
class CurrencyData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $currencyDirector
         */
        $currencyDirector = $this->getDirector('currency');

        /**
         * Dollar.
         */
        $currencyDollar = $currencyDirector
            ->create()
            ->setName('Dollar')
            ->setSymbol('$')
            ->setIso('USD');

        $currencyDirector->save($currencyDollar);
        $this->setReference('currency-dollar', $currencyDollar);

        /**Euro
         */
        $currencyEuro = $currencyDirector
            ->create()
            ->setName('Euro')
            ->setSymbol('€')
            ->setIso('EUR');

        $currencyDirector->save($currencyEuro);
        $this->setReference('currency-euro', $currencyEuro);

        /**
         * Pound.
         */
        $currencyPound = $currencyDirector
            ->create()
            ->setName('Pound')
            ->setSymbol('£')
            ->setIso('GBP');

        $currencyDirector->save($currencyPound);
        $this->setReference('currency-pound', $currencyPound);

        /**
         * Ien.
         */
        $currencyIen = $currencyDirector
            ->create()
            ->setName('Yen')
            ->setSymbol('円')
            ->setIso('JPY');

        $currencyDirector->save($currencyIen);
        $this->setReference('currency-ien', $currencyIen);
    }
}
