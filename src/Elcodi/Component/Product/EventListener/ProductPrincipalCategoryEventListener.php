<?php

namespace Elcodi\Component\Product\EventListener;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;

/**
 * Class ProductPrincipalCategoryEventListener
 */
class ProductPrincipalCategoryEventListener
{
    /**
     * Before the flush we check that in case the product has any category at
     * least has a principal category
     *
     * @param PreFlushEventArgs $args The pre flush event arguments.
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $entityManager       = $args->getEntityManager();
        $scheduledInsertions = $entityManager->getUnitOfWork()->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if (
                $entity instanceof ProductInterface &&
                !$entity->getPrincipalCategory()
            ) {
                $categories = $entity->getCategories();

                if (0 < $categories->count()) {
                    $entity->setPrincipalCategory($categories->first());
                }
            }
        }
    }
}
