<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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

namespace Elcodi\Component\Product\EventListener;

use Doctrine\ORM\Event\PreFlushEventArgs;

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductBelongsPrincipalCategoryEventListener
 */
class ProductBelongsPrincipalCategoryEventListener
{
    /**
     * Before the flush we check that in case the product has a principal
     * category, this product also belongs to this category
     *
     * @param PreFlushEventArgs $args The pre flush event arguments.
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $scheduledInsertions = $entityManager
            ->getUnitOfWork()
            ->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof ProductInterface) {
                $principalCategory = $entity->getPrincipalCategory();
                $categories = $entity->getCategories();

                if (
                    !empty($principalCategory) &&
                    !$categories->contains($principalCategory)
                ) {
                    $categories->add($principalCategory);
                    $entity->setCategories($categories);
                }
            }
        }
    }
}
