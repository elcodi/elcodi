<?php

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
        $entityManager       = $args->getEntityManager();
        $scheduledInsertions = $entityManager->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if (
                $entity instanceof ProductInterface
            ) {
                $principalCategory = $entity->getPrincipalCategory();
                $categories        = $entity->getCategories();

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
