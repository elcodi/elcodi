<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ProductBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\ProductBundle\Entity\Interfaces\CategoryInterface;

/**
 * Class CategoryData
 */
class CategoryData extends AbstractFixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Category
         *
         * @var CategoryInterface $rootCategory
         */
        $rootCategory = $this->container->get('elcodi.core.product.factory.category')->create();
        $rootCategory
            ->setName('root-category')
            ->setSlug('root-category')
            ->setRoot(true);

        $manager->persist($rootCategory);
        $this->addReference('rootCategory', $rootCategory);

        /**
         * Category
         *
         * @var CategoryInterface $category
         */
        $category = $this->container->get('elcodi.core.product.factory.category')->create();
        $category
            ->setName('category')
            ->setSlug('category')
            ->setParent($rootCategory)
            ->setRoot(false);

        $manager->persist($category);
        $this->addReference('category', $category);

        $manager->flush();
    }
}
