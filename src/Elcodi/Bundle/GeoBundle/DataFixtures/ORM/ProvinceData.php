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
 */

namespace Elcodi\Bundle\GeoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Geo\Factory\ProvinceFactory;

/**
 * Class ProvinceData
 */
class ProvinceData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ProvinceFactory $provinceFactory
         */
        $provinceFactory = $this->getFactory('province');
        $provinceObjectManager = $this->getObjectManager('province');

        $provinceBarcelones = $provinceFactory
            ->create()
            ->setId('es-cat-bar')
            ->setCode('bar')
            ->setName('Barcelonès')
            ->setState($this->getReference('state-catalunya'))
            ->setEnabled(true);

        $provinceObjectManager->persist($provinceBarcelones);
        $this->addReference('province-barcelones', $provinceBarcelones);

        $provinceObjectManager->flush([
            $provinceBarcelones
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
            'Elcodi\Bundle\GeoBundle\DataFixtures\ORM\StateData',
        ];
    }
}
