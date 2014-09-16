<?php

/**
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
 */

namespace Elcodi\Component\Comment\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CommentRepository
 */
class CommentRepository extends EntityRepository
{
    /**
     * Get all comments ordered by parent elements and position, ascendant.
     *
     * @param string $source Source
     *
     * @return Collection Category collection
     */
    public function getAllCommentsSortedByParentAndIdAsc($source)
    {
        /**
         * @var QueryBuilder
         */
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->where('c.source = :source')
            ->where('c.enabled = :enabled')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.id', 'asc')
            ->setParameter('enabled', true);

        $comments = $queryBuilder
            ->getQuery()
            ->getResult();

        return new ArrayCollection($comments);
    }
}
