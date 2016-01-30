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

namespace Elcodi\Bundle\StoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class StoreData.
 */
class StoreData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $storeDirector
         */
        $storeDirector = $this->getDirector('store');
        $address = $this->getReference('address-sant-celoni');
        $language = $this->getReference('language-es');
        $currency = $this->getReference('currency-euro');

        $store = $storeDirector
            ->create()
            ->setName('Store')
            ->setLeitmotiv('Uh yes, I don\'t know what... this is a store...')
            ->setEmail('email@email.com')
            ->setTracker('123456')
            ->setTemplate('fhsjkhfjklsa')
            ->setUseStock(true)
            ->setAddress($address)
            ->setDefaultLanguage($language)
            ->setDefaultCurrency($currency);

        $storeDirector->save($store);
        $this->setReference('store', $store);
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
            'Elcodi\Bundle\LanguageBundle\DataFixtures\ORM\LanguageData',
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\AddressData',
        ];
    }
}
