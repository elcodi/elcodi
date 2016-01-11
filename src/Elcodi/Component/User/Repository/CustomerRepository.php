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

namespace Elcodi\Component\User\Repository;

use Doctrine\ORM\EntityRepository;

use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Repository\Interfaces\UserEmaileableInterface;

/**
 * Class CustomerRepository.
 */
class CustomerRepository extends EntityRepository implements UserEmaileableInterface
{
    /**
     * Find one Entity given an email.
     *
     * @param string $email Email
     *
     * @return AbstractUserInterface|null User found
     */
    public function findOneByEmail($email)
    {
        $user = $this
            ->findOneBy([
                'email' => $email,
            ]);

        return ($user instanceof AbstractUserInterface)
            ? $user
            : null;
    }

    /**
     * Find a user address by it's id.
     *
     * @param int $customerId The customer Id
     * @param int $addressId  The address Id
     *
     * @return bool
     */
    public function findAddress($customerId, $addressId)
    {
        $response = $this
            ->createQueryBuilder('c')
            ->select(
                ['c', 'a']
            )
            ->innerJoin('c.addresses', 'a')
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
            $customer = reset($response);
            $addresses = $customer->getAddresses();
            if ($addresses) {
                return $addresses->first();
            }
        }

        return false;
    }
}
