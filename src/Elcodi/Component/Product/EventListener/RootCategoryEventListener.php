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

namespace Elcodi\Component\Product\EventListener;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

use Elcodi\Component\Product\Entity\Interfaces\CategoryInterface;

/**
 * Class RootCategoryEventListener.
 */
class RootCategoryEventListener
{
    /**
     * Pre update event listener.
     *
     * @param PreUpdateEventArgs $eventArgs The pre update event args.
     *
     * @return $this Self object
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CategoryInterface) {
            $this->removeParentCategoryForRootCategory($entity);
        }

        return $this;
    }

    /**
     * Pre flush event listener.
     *
     * @param PreFlushEventArgs $args The pre flush event args.
     *
     * @return $this Self object
     */
    public function preFlush(PreFlushEventArgs $args)
    {
        $scheduledInsertions = $args
            ->getEntityManager()
            ->getUnitOfWork()
            ->getScheduledEntityInsertions();

        foreach ($scheduledInsertions as $entity) {
            if ($entity instanceof CategoryInterface) {
                $this->removeParentCategoryForRootCategory($entity);
            }
        }

        return $this;
    }

    /**
     * Removes the parent category for a root category.
     *
     * @param CategoryInterface $category The category.
     */
    private function removeParentCategoryForRootCategory(CategoryInterface $category)
    {
        if ($category->isRoot()) {
            $category->setParent(null);
        }
    }
}
