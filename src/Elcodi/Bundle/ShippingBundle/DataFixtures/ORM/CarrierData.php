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
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Currency\Entity\Interfaces\CurrencyInterface;
use Elcodi\Component\Currency\Entity\Money;
use Elcodi\Component\Shipping\ElcodiShippingRangeTypes;
use Elcodi\Component\Zone\Entity\Interfaces\ZoneInterface;

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
         * @var ObjectDirector $carrierDirector
         * @var ObjectDirector $shippingRangeDirector
         */
        $carrierDirector = $this->getDirector('carrier');
        $shippingRangeDirector = $this->getDirector('shipping_range');

        /**
         * @var CurrencyInterface $currencyEuro
         * @var ZoneInterface $zone08021
         * @var ZoneInterface $zoneSantCelone
         */
        $currencyEuro = $this->getReference('currency-euro');
        $zone08021 = $this->getReference('zone-08021');
        $zoneViladecavalls = $this->getReference('zone-viladecavalls');

        /**
         * Carrier1 from Viladecavalls to Barcelona
         */
        $carrier1 = $carrierDirector
            ->create()
            ->setName('carrier-1')
            ->setDescription('Carrier 1')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $ShippingPriceRange1 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier1)
            ->setName('From 0€ to 10€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(0, $currencyEuro))
            ->setToPrice(Money::create(1000, $currencyEuro))
            ->setPrice(Money::create(900, $currencyEuro))
            ->setEnabled(true);

        $ShippingPriceRange2 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier1)
            ->setName('From 10€ to 20€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(1000, $currencyEuro))
            ->setToPrice(Money::create(2000, $currencyEuro))
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $ShippingPriceRange3 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier1)
            ->setName('Free for up to 20€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(2000, $currencyEuro))
            ->setToPrice(Money::create(999999999, $currencyEuro))
            ->setPrice(Money::create(115, $currencyEuro))
            ->setEnabled(true);

        $carrierDirector->save($carrier1);
        $shippingRangeDirector->save($ShippingPriceRange1);
        $shippingRangeDirector->save($ShippingPriceRange2);
        $shippingRangeDirector->save($ShippingPriceRange3);
        $this->addReference('carrier-1', $carrier1);

        /**
         * Carrier2 from Viladecavalls to Barcelona
         */
        $carrier2 = $carrierDirector
            ->create()
            ->setName('carrier-2')
            ->setDescription('Carrier 2')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $ShippingPriceRangeB1 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier2)
            ->setName('From 0€ to 15€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(0, $currencyEuro))
            ->setToPrice(Money::create(1500, $currencyEuro))
            ->setPrice(Money::create(700, $currencyEuro))
            ->setEnabled(true);

        $ShippingPriceRangeB2 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier2)
            ->setName('From 15€ to 30€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(1500, $currencyEuro))
            ->setToPrice(Money::create(3000, $currencyEuro))
            ->setPrice(Money::create(300, $currencyEuro))
            ->setEnabled(true);

        $ShippingPriceRangeB3 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_PRICE)
            ->setCarrier($carrier2)
            ->setName('Free for up to 30€')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromPrice(Money::create(3000, $currencyEuro))
            ->setToPrice(Money::create(999999999, $currencyEuro))
            ->setPrice(Money::create(100, $currencyEuro))
            ->setEnabled(true);

        $carrierDirector->save($carrier2);
        $shippingRangeDirector->save($ShippingPriceRangeB1);
        $shippingRangeDirector->save($ShippingPriceRangeB2);
        $shippingRangeDirector->save($ShippingPriceRangeB3);
        $this->addReference('carrier-2', $carrier2);

        /**
         * Carrier3 from Viladecavalls to Barcelona
         */
        $carrier3 = $carrierDirector
            ->create()
            ->setName('carrier-3')
            ->setDescription('Carrier 3')
            ->setTax($this->getReference('tax-16'))
            ->setEnabled(true);

        $ShippingWeightRange1 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier3)
            ->setName('From 0g to 500g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromWeight(0)
            ->setToWeight(500)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $ShippingWeightRange2 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier3)
            ->setName('From 500g to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromWeight(500)
            ->setToWeight(1000)
            ->setPrice(Money::create(700, $currencyEuro))
            ->setEnabled(true);

        $ShippingWeightRange3 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier3)
            ->setName('Up to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zone08021)
            ->setFromWeight(1000)
            ->setToWeight(9999999999)
            ->setPrice(Money::create(1000, $currencyEuro))
            ->setEnabled(true);

        $carrierDirector->save($carrier3);
        $shippingRangeDirector->save($ShippingWeightRange1);
        $shippingRangeDirector->save($ShippingWeightRange2);
        $shippingRangeDirector->save($ShippingWeightRange3);
        $this->addReference('carrier-3', $carrier3);

        /**
         * Carrier4 from Barcelona to Viladecavalls
         */
        $carrier4 = $carrierDirector
            ->create()
            ->setName('carrier-4')
            ->setDescription('Carrier 4')
            ->setTax($this->getReference('tax-21'))
            ->setEnabled(true);

        $ShippingWeightRangeB1 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier4)
            ->setName('From 0g to 700g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(0)
            ->setToWeight(700)
            ->setPrice(Money::create(500, $currencyEuro))
            ->setEnabled(true);

        $ShippingWeightRangeB2 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier4)
            ->setName('From 500g to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(700)
            ->setToWeight(1200)
            ->setPrice(Money::create(1500, $currencyEuro))
            ->setEnabled(true);

        $ShippingWeightRangeB3 = $shippingRangeDirector
            ->create()
            ->setType(ElcodiShippingRangeTypes::TYPE_WEIGHT)
            ->setCarrier($carrier4)
            ->setName('Up to 1000g')
            ->setFromZone($zoneViladecavalls)
            ->setToZone($zoneViladecavalls)
            ->setFromWeight(1200)
            ->setToWeight(9999999999)
            ->setPrice(Money::create(3000, $currencyEuro))
            ->setEnabled(true);

        $carrierDirector->save($carrier4);
        $shippingRangeDirector->save($ShippingWeightRangeB1);
        $shippingRangeDirector->save($ShippingWeightRangeB2);
        $shippingRangeDirector->save($ShippingWeightRangeB3);
        $this->addReference('carrier-4', $carrier4);
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
            'Elcodi\Bundle\ZoneBundle\DataFixtures\ORM\ZoneData',
            'Elcodi\Bundle\CurrencyBundle\DataFixtures\ORM\CurrencyData',
        ];
    }
}
