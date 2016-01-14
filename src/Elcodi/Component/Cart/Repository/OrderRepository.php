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

namespace Elcodi\Component\Cart\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\Cart\Entity\Interfaces\OrderInterface;

/**
 * Class OrderRepository.
 */
class OrderRepository extends EntityRepository
{
    /**
     * Gets the orders to prepare.
     *
     * @return OrderInterface[]
     */
    public function getOrdersToPrepare()
    {
        $res = $this->createQueryBuilder('o')
            ->innerJoin('o.shippingLastStateLine', 'sl')
            ->where('sl.name = \'preparing\'')
            ->orderBy('o.updatedAt', 'ASC')
            ->getQuery()
            ->getResult();

        return $res;
    }
}
