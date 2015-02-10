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

namespace Elcodi\Bundle\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Menu\Factory\NodeFactory;

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
         * @var NodeFactory $menuNodeFactory
         */
        $menuNodeFactory = $this->getFactory('menu_node');
        $menuNodeObjectManager = $this->getObjectManager('menu_node');

        $menuNodeHim = $menuNodeFactory
            ->create()
            ->setName('him')
            ->setCode('him')
            ->setUrl('elcodi.dev/him')
            ->setEnabled(true);

        $menuNodeHer = $menuNodeFactory
            ->create()
            ->setName('her')
            ->setCode('her')
            ->setUrl('elcodi.dev/her')
            ->setEnabled(true);

        $menuNodeVogue = $menuNodeFactory
            ->create()
            ->setName('vogue')
            ->setCode('vogue')
            ->setEnabled(true)
            ->addSubnode($menuNodeHim)
            ->addSubnode($menuNodeHer);

        $menuNodeObjectManager->persist($menuNodeVogue);
        $this->addReference('menu-node-him', $menuNodeHim);
        $this->addReference('menu-node-her', $menuNodeHer);
        $this->addReference('menu-node-vogue', $menuNodeVogue);

        $menuNodeObjectManager->flush([
            $menuNodeVogue
        ]);
    }
}
