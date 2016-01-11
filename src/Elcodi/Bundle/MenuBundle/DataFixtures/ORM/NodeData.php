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

namespace Elcodi\Bundle\MenuBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class NodeData.
 */
class NodeData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ObjectDirector $menuNodeDirector
         */
        $menuNodeDirector = $this->getDirector('menu_node');

        $menuNodeHim = $menuNodeDirector
            ->create()
            ->setName('him')
            ->setCode('him')
            ->setUrl('elcodi.dev/him')
            ->setActiveUrls([])
            ->setEnabled(true);

        $menuNodeHer = $menuNodeDirector
            ->create()
            ->setName('her')
            ->setCode('her')
            ->setUrl('elcodi.dev/her')
            ->setActiveUrls(
                [
                    'her_products_list_route',
                    'her_offers_list_route',
                ]
            )
            ->setEnabled(true);

        $menuNodeVogue = $menuNodeDirector
            ->create()
            ->setName('vogue')
            ->setCode('vogue')
            ->setEnabled(true)
            ->setActiveUrls([])
            ->addSubnode($menuNodeHim)
            ->addSubnode($menuNodeHer);

        $menuNodeDirector->save($menuNodeVogue);
        $this->addReference('menu-node-him', $menuNodeHim);
        $this->addReference('menu-node-her', $menuNodeHer);
        $this->addReference('menu-node-vogue', $menuNodeVogue);
    }
}
