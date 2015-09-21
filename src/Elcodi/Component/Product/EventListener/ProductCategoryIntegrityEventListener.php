<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

use Elcodi\Component\Product\Entity\Interfaces\ProductInterface;
use Elcodi\Component\Product\Services\CategoryIntegrityFixer;

/**
 * Class ProductCategoryIntegrityEventListener
 */
class ProductCategoryIntegrityEventListener
{
    /**
     * @var CategoryIntegrityFixer
     *
     * A category integrity fixer.
     */
    private $categoryIntegrityFixer;

    /**
     * Builds a new class
     *
     * @param CategoryIntegrityFixer $categoryIntegrityFixer A category
     *                                                       integrity fixer.
     */
    public function __construct(
        CategoryIntegrityFixer $categoryIntegrityFixer
    ) {
        $this->categoryIntegrityFixer = $categoryIntegrityFixer;
    }

    /**
     * Before the flush we check that the product categories are right.
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
                $this
                    ->categoryIntegrityFixer
                    ->fixProduct($entity);
            }
        }
    }

    /**
     * Before an update we check that the product categories are right.
     *
     * @param PreUpdateEventArgs $event The pre update event.
     */
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $entity = $event->getEntity();
        if ($entity instanceof ProductInterface) {
            $this
                ->categoryIntegrityFixer
                ->fixProduct($entity);
        }
    }
}
