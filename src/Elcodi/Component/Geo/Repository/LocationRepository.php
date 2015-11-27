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

namespace Elcodi\Component\Geo\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class LocationRepository
 */
class LocationRepository extends EntityRepository
{
    /**
     * Return all the root locations.
     *
     * @return array
     */
    public function findAllRoots()
    {
        $roots = $this
            ->createQueryBuilder('l')
            ->leftJoin('l.parents', 'p')
            ->andWhere('p.id is NULL')
            ->getQuery()
            ->getResult();

        return $roots;
    }
}
