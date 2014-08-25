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

namespace Elcodi\Bundle\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Menu\Entity\Menu\Interfaces\MenuInterface;

/**
 * Class MenuData
 */
class MenuData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var MenuInterface $menuAdmin
         */
        $menuAdmin = $this
            ->container
            ->get('elcodi.factory.menu')
            ->create()
            ->setCode('menu-admin')
            ->setEnabled(true)
            ->addSubnode($this->getReference('menu-node-vogue'));

        $manager->persist($menuAdmin);
        $this->addReference('menu-admin', $menuAdmin);

        /**
         * @var MenuInterface $menuAdmin
         */
        $menuFront = $this
            ->container
            ->get('elcodi.factory.menu')
            ->create()
            ->setCode('menu-front')
            ->setEnabled(true)
            ->addSubnode($this->getReference('menu-node-him'))
            ->addSubnode($this->getReference('menu-node-her'));

        $manager->persist($menuFront);
        $this->addReference('menu-front', $menuFront);

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
            'Elcodi\Bundle\MenuBundle\DataFixtures\ORM\NodeData',
        ];
    }
}
