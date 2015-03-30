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

namespace Elcodi\Component\User\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Repository\Interfaces\UserEmaileableInterface;

/**
 * CustomerRepository
 */
class CustomerRepository extends EntityRepository implements UserEmaileableInterface
{
    /**
     * Find one Entity given an email
     *
     * @param string $email Email
     *
     * @return CustomerInterface User found
     */
    public function findOneByEmail($email)
    {
        return $this->findOneBy([
            'email' => $email,
        ]);
    }

    /**
     * Find a user address by it's id
     *
     * @param integer $customerId The customer Id
     * @param integer $addressId  The address Id
     *
     * @return boolean
     */
    public function findAddress($customerId, $addressId)
    {
        $response = $this
            ->createQueryBuilder('c')
            ->select(
                ['c', 'a']
            )
            ->join('c.addresses', 'a')
            ->where('c.id = :customerId')
            ->andWhere('a.id = :addressId')
            ->setParameter('customerId', $customerId)
            ->setParameter('addressId', $addressId)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        if (!empty($response)) {
            /**
             * @var CustomerInterface $customer
             */
            $customer  = reset($response);
            $addresses = $customer->getAddresses();
            if ($addresses) {
                return $addresses->first();
            }
        }

        return false;
    }
}
