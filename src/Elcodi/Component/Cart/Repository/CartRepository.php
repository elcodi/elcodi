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

use Elcodi\Component\Cart\Entity\Interfaces\CartInterface;
use Elcodi\Component\Geo\Entity\Interfaces\AddressInterface;

/**
 * Class CartRepository.
 */
class CartRepository extends EntityRepository
{
    /**
     * Finds all the carts that had an address for billing or delivery.
     *
     * @param AddressInterface $address The address to search
     *
     * @return CartInterface[]
     */
    public function findAllCartsWithAddress(AddressInterface $address)
    {
        $queryBuilder = $this
            ->createQueryBuilder('c');

        $result = $queryBuilder
            ->innerJoin('c.billingAddress', 'b')
            ->innerJoin('c.deliveryAddress', 'd')
            ->where(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->eq('b.id', ':customerId'),
                    $queryBuilder->expr()->eq('c.id', ':addressId')
                )
            )
            ->setParameter('customerId', $address->getId())
            ->setParameter('addressId', $address->getId())
            ->getQuery()
            ->getResult();

        return $result;
    }
}
