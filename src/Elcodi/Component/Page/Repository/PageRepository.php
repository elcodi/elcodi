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

namespace Elcodi\Component\Page\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Page\Entity\Interfaces\PageInterface;

/**
 * Class PageRepository
 *
 * @author Jonas HAOUZI <haouzijonas@gmail.com>
 * @author Àlex Corretgé <alex@corretge.cat>
 * @author Berny Cantos <be@rny.cc>
 */
class PageRepository extends EntityRepository
{
    /**
     * Find one Page given its path
     *
     * @param string $path Page path
     *
     * @return PageInterface|null Page
     */
    public function findOneByPath($path)
    {
        return $this->findOneBy([
            'path'    => $path,
            'enabled' => true,
        ]);
    }

    /**
     * Find pages paginated
     *
     * @param string  $type          Type
     * @param integer $page          Page
     * @param integer $numberPerPage Number per page
     *
     * @return array Pages
     */
    public function findPages($type, $page, $numberPerPage)
    {
        $offset = (($page - 1) * $numberPerPage);

        return $this
            ->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->andWhere('p.type = :type')
            ->orderBy('p.publicationDate', 'DESC')
            ->setParameters([
                'enabled' => true,
                'type'    => $type,
            ])
            ->setFirstResult($offset)
            ->setMaxResults($numberPerPage)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * Find pages paginated
     *
     * @param string $type Type
     *
     * @return integer Number of pages
     */
    public function getNumberOfEnabledPages($type)
    {
        return $this
            ->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.enabled = :enabled')
            ->andWhere('p.type = :type')
            ->setParameters([
                'enabled' => true,
                'type'    => $type,
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }
}
