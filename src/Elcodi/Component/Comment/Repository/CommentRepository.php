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

namespace Elcodi\Component\Comment\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CommentRepository.
 */
class CommentRepository extends EntityRepository
{
    /**
     * Get all comments ordered by parent elements and position, ascendant.
     *
     * @param string $source  Source
     * @param string $context Context of comment
     *
     * @return Collection Category collection
     */
    public function getAllCommentsSortedByParentAndIdAsc($source, $context)
    {
        /**
         * @var QueryBuilder
         */
        $queryBuilder = $this
            ->createQueryBuilder('c')
            ->where('c.source = :source')
            ->andWhere('c.context = :context')
            ->andWhere('c.enabled = :enabled')
            ->addOrderBy('c.parent', 'asc')
            ->addOrderBy('c.id', 'asc')
            ->setParameters([
                'source' => $source,
                'context' => $context,
                'enabled' => true,
            ]);

        $comments = $queryBuilder
            ->getQuery()
            ->getResult();

        return new ArrayCollection($comments);
    }
}
