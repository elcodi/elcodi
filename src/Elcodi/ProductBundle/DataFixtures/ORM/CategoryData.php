<?php

/**
 * This file is part of BeEcommerce.
 *
 * @author Befactory Team
 * @since  2013
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
