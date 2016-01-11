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

namespace Elcodi\Component\Metric\Core\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Metric\Core\Entity\Interfaces\EntryInterface;

/**
 * Class EntryRepository.
 */
class EntryRepository extends EntityRepository
{
    /**
     * Load entries from last X days.
     *
     * @param int $days Days
     *
     * @return EntryInterface[] Entries
     */
    public function getEntriesFromLastDays($days)
    {
        $from = new DateTime();
        $from->modify('-' . $days . ' days');

        return $this
            ->createQueryBuilder('e')
            ->where('e.createdAt >= :from')
            ->setParameters([
                'from' => $from,
            ])
            ->getQuery()
            ->getResult();
    }
}
