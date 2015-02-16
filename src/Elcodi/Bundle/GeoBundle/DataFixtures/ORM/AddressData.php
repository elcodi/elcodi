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

namespace Elcodi\Bundle\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Entity\Address;
use Elcodi\Component\Geo\Factory\AddressFactory;

/**
 * Class AddressData
 */
class AddressData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var AddressFactory $addressFactory
         */
        $addressFactory = $this->getFactory('address');
        $addressObjectManager = $this->getObjectManager('address');

        $addressBarcelona = $addressFactory
            ->create()
            ->setName('Some address')
            ->setRecipientName('user name')
            ->setRecipientSurname('user surname')
            ->setAddress('Some street 123')
            ->setAddressMore('1-2')
            ->setPhone('123-456789')
            ->setMobile('000-123456')
            ->setComments('Some comments')
            ->setCity($this->getReference('location-sant-celoni')->getId())
            ->setPostalcode('08021')
            ->setEnabled(true);

        $addressObjectManager->persist($addressBarcelona);
        $this->addReference('address-barcelona', $addressBarcelona);

        $addressViladecavalls = $addressFactory
            ->create()
            ->setName('Some other address')
            ->setRecipientName('user2 name')
            ->setRecipientSurname('user2 surname')
            ->setAddress('Some other street 123')
            ->setAddressMore('3-4')
            ->setPhone('123-456789')
            ->setMobile('000-123456')
            ->setComments('Some other comments')
            ->setCity($this->getReference('location-viladecavalls')->getId())
            ->setPostalcode('08232')
            ->setEnabled(true);

        $addressObjectManager->persist($addressViladecavalls);
        $this->addReference('address-viladecavalls', $addressViladecavalls);

        $addressObjectManager->flush([
            $addressBarcelona,
            $addressViladecavalls,
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\LocationData',
        ];
    }
}
