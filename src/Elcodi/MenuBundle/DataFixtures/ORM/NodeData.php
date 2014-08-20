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

namespace Elcodi\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\MenuBundle\Entity\Menu\Interfaces\NodeInterface;

/**
 * Class NodeData
 */
class NodeData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var NodeInterface $menuNodeHim
         * @var NodeInterface $menuNodeHer
         * @var NodeInterface $menuNodeVogue
         */
        $menuNodeHim = $this
            ->container
            ->get('elcodi.factory.menu_node')
            ->create()
            ->setName('him')
            ->setCode('him')
            ->setUrl('elcodi.dev/him')
            ->setEnabled(true);

        $menuNodeHer = $this
            ->container
            ->get('elcodi.factory.menu_node')
            ->create()
            ->setName('her')
            ->setCode('her')
            ->setUrl('elcodi.dev/her')
            ->setEnabled(true);

        $menuNodeVogue = $this
            ->container
            ->get('elcodi.factory.menu_node')
            ->create()
            ->setName('vogue')
            ->setCode('vogue')
            ->setEnabled(true)
            ->addSubnode($menuNodeHim)
            ->addSubnode($menuNodeHer);

        $manager->persist($menuNodeVogue);
        $this->addReference('menu-node-him', $menuNodeHim);
        $this->addReference('menu-node-her', $menuNodeHer);
        $this->addReference('menu-node-vogue', $menuNodeVogue);

        $manager->flush();
    }
}
