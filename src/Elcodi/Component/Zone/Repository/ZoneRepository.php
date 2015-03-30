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

namespace Elcodi\Component\Zone\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

/**
 * Class ZoneRepository
 */
class ZoneRepository extends EntityRepository
{
    /**
     * Find active zones
     *
     * @return Collection Active zones
     */
    public function getActiveZones()
    {
        $zones = $this
            ->createQueryBuilder('z')
            ->where('z.enabled = :enabled')
            ->setParameters([
                'enabled' => true,
            ])
            ->getQuery()
            ->getArrayResult();

        return new ArrayCollection($zones);
    }
}
