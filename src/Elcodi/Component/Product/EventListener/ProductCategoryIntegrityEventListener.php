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

use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\Event\OnFlushEventArgs;

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
     * @param OnFlushEventArgs $args The pre flush event arguments.
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $unitOfWork = $args
            ->getEntityManager()
            ->getUnitOfWork();

        $scheduledInsertions = $unitOfWork->getScheduledEntityInsertions();
        $scheduledUpdates = $unitOfWork->getScheduledEntityUpdates();

        $entitiesChanged = array_merge($scheduledInsertions, $scheduledUpdates);
        $this->fixProductEntities($entitiesChanged, $unitOfWork);
    }


    /**
     * Fixes all the product entities found.
     *
     * @param array      $entities   The entities being changed.
     * @param UnitOfWork $unitOfWork The unit of work.
     */
    protected function fixProductEntities( array $entities, UnitOfWork $unitOfWork )
    {
        $computeChangeSets = false;
        foreach ($entities as $entity) {
            if ($entity instanceof ProductInterface) {
                $this
                    ->categoryIntegrityFixer
                    ->fixProduct($entity);

                $computeChangeSets = true;
            }
        }

        if ($computeChangeSets) {
            $unitOfWork->computeChangeSets();
        }
    }
}
