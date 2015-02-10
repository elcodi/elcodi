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

namespace Elcodi\Bundle\ShippingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Geo\Entity\Interfaces\ZoneInterface;
use Elcodi\Component\Shipping\Factory\CarrierFactory;
use Elcodi\Component\Shipping\Factory\CarrierPriceRangeFactory;
use Elcodi\Component\Shipping\Factory\CarrierWeightRangeFactory;

/**
 * Class CarrierData
 */
class CarrierData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var CarrierFactory $carrierFactory
         * @var CarrierPriceRangeFactory  $carrierPriceRangeFactory
         * @var CarrierWeightRangeFactory $carrierWeightRangeFactory
         */
        $carrierFactory = $this->getFactory('carrier');
        $carrierPriceRangeFactory = $this->getFactory('carrier_price_range');
        $carrierWeightRangeFactory = $this->getFactory('carrier_weight_range');
        $carrierObjectManager = $this->getObjectManager('carrier');
        $carrierPriceRangeObjectManager = $this->getObjectManager('carrier_price_range');
        $carrierWeightRangeObjectManager = $this->getObjectManager('carrier_weight_range');

        /**
         * @var CurrencyInterface $currencyEuro
         * @var ZoneInterface $zoneBarcelona
         * @var ZoneInterface $zoneViladecavalls
         */
        $currencyEuro = $this->getReference('currency-euro');
        $zoneBarcelona = $this->getReference('zone-barcelona');
        $zoneViladecavalls = $this->getReference('zone-viladecavalls');

        /**
         * Carrier1 from Viladecavalls to Barcelona
         */
        $carrier1 = $carrierFactory
            ->create()
            ->setName('carrier-1')
            ->setDescription('Carrier 1')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $carrierPriceRange1 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier1)
            ->setName('From 0€ to 10€')
            ->setDescription('From 0€ to 10€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(0, $currencyEuro))
            ->setToPrice(Money::create(1000, $currencyEuro))
            ->setPrice(Money::create(900, $currencyEuro))
            ->setEnabled(true);

        $carrierPriceRange2 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier1)
            ->setName('From 10€ to 20€')
            ->setDescription('From 10€ to 20€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(1000, $currencyEuro))
            ->setToPrice(Money::create(2000, $currencyEuro))
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $carrierPriceRange3 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier1)
            ->setName('Free for up to 20€')
            ->setDescription('Free shipping for up to 20€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(2000, $currencyEuro))
            ->setToPrice(Money::create(999999999, $currencyEuro))
            ->setPrice(Money::create(115, $currencyEuro))
            ->setEnabled(true);

        $carrierObjectManager->persist($carrier1);
        $carrierPriceRangeObjectManager->persist($carrierPriceRange1);
        $carrierPriceRangeObjectManager->persist($carrierPriceRange2);
        $carrierPriceRangeObjectManager->persist($carrierPriceRange3);
        $this->addReference('carrier-1', $carrier1);

        /**
         * Carrier2 from Viladecavalls to Barcelona
         */
        $carrier2 = $carrierFactory
            ->create()
            ->setName('carrier-2')
            ->setDescription('Carrier 2')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $carrierPriceRangeB1 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier2)
            ->setName('From 0€ to 15€')
            ->setDescription('From 0€ to 15€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(0, $currencyEuro))
            ->setToPrice(Money::create(1500, $currencyEuro))
            ->setPrice(Money::create(700, $currencyEuro))
            ->setEnabled(true);

        $carrierPriceRangeB2 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier2)
            ->setName('From 15€ to 30€')
            ->setDescription('From 15€ to 30€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(1500, $currencyEuro))
            ->setToPrice(Money::create(3000, $currencyEuro))
            ->setPrice(Money::create(300, $currencyEuro))
            ->setEnabled(true);

        $carrierPriceRangeB3 = $carrierPriceRangeFactory
            ->create()
            ->setCarrier($carrier2)
            ->setName('Free for up to 30€')
            ->setDescription('Free shipping for up to 30€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromPrice(Money::create(3000, $currencyEuro))
            ->setToPrice(Money::create(999999999, $currencyEuro))
            ->setPrice(Money::create(100, $currencyEuro))
            ->setEnabled(true);

        $carrierObjectManager->persist($carrier2);
        $carrierPriceRangeObjectManager->persist($carrierPriceRangeB1);
        $carrierPriceRangeObjectManager->persist($carrierPriceRangeB2);
        $carrierPriceRangeObjectManager->persist($carrierPriceRangeB3);
        $this->addReference('carrier-2', $carrier2);

        /**
         * Carrier3 from Viladecavalls to Barcelona
         */
        $carrier3 = $carrierFactory
            ->create()
            ->setName('carrier-3')
            ->setDescription('Carrier 3')
            ->setTax($this->getReference('tax-16'))
            ->setEnabled(true);

        $carrierWeightRange1 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier3)
            ->setName('From 0g to 500g')
            ->setDescription('From 0g to 500g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromWeight(0)
            ->setToWeight(500)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $carrierWeightRange2 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier3)
            ->setName('From 500g to 1000g')
            ->setDescription('From 500g to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromWeight(500)
            ->setToWeight(1000)
            ->setPrice(Money::create(700, $currencyEuro))
            ->setEnabled(true);

        $carrierWeightRange3 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier3)
            ->setName('Up to 1000g')
            ->setDescription('Up to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneBarcelona)
            ->setFromWeight(1000)
            ->setToWeight(9999999999)
            ->setPrice(Money::create(1000, $currencyEuro))
            ->setEnabled(true);

        $carrierObjectManager->persist($carrier3);
        $carrierWeightRangeObjectManager->persist($carrierWeightRange1);
        $carrierWeightRangeObjectManager->persist($carrierWeightRange2);
        $carrierWeightRangeObjectManager->persist($carrierWeightRange3);
        $this->addReference('carrier-3', $carrier3);

        /**
         * Carrier4 from Barcelona to Viladecavalls
         */
        $carrier4 = $carrierFactory
            ->create()
            ->setName('carrier-4')
            ->setDescription('Carrier 4')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $carrierWeightRangeB1 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier4)
            ->setName('From 0g to 700g')
            ->setDescription('From 0g to 700g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(0)
            ->setToWeight(700)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $carrierWeightRangeB2 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier4)
            ->setName('From 500g to 1000g')
            ->setDescription('From 500g to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(700)
            ->setToWeight(1200)
            ->setPrice(Money::create(1500, $currencyEuro))
            ->setEnabled(true);

        $carrierWeightRangeB3 = $carrierWeightRangeFactory
            ->create()
            ->setCarrier($carrier4)
            ->setName('Up to 1000g')
            ->setDescription('Up to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(1200)
            ->setToWeight(9999999999)
            ->setPrice(Money::create(3000, $currencyEuro))
            ->setEnabled(true);

        $carrierObjectManager->persist($carrier4);
        $carrierWeightRangeObjectManager->persist($carrierWeightRangeB1);
        $carrierWeightRangeObjectManager->persist($carrierWeightRangeB2);
        $carrierWeightRangeObjectManager->persist($carrierWeightRangeB3);
        $this->addReference('carrier-4', $carrier4);

        $manager->flush();
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
            'Elcodi\Bundle\TaxBundle\DataFixtures\ORM\TaxData',
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\ZoneData',
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
        ];
    }
}
