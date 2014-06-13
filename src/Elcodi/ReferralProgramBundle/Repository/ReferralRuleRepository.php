<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author  ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\Repository;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Elcodi\ReferralProgramBundle\Entity\ReferralRule;

/**
 * ReferralRuleRepository
 */
class ReferralRuleRepository extends EntityRepository
{

    /**
     * Get first actual enabled referral rule
     *
     * @return ReferralRule Instance found
     */
    public function findEnabledReferralRule()
    {
        return $this->findEnabledReferralRuleFromDateTime(new DateTime);
    }

    /**
     * Get first enabled referral rule, given a DateTime
     *
     * @param DateTime $dateTime DateTime instance
     *
     * @return ReferralRule Instance found
     */
    public function findEnabledReferralRuleFromDateTime(DateTime $dateTime)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        $queryResults = $queryBuilder
            ->where('r.enabled = :enabled')
            ->andWhere('r.validFrom <= :datetime')
            ->andWhere(
                $queryBuilder->expr()->orx(
                    $queryBuilder->expr()->gte('r.validTo', ':datetime'),
                    $queryBuilder->expr()->isNull('r.validTo')
                )
            )
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1)
            ->setParameters(array(
                'enabled'   =>  true,
                'datetime'  =>  $dateTime
            ))
            ->getQuery()
            ->getResult();

        $rules = new ArrayCollection($queryResults);

        return $rules->first();
    }

    /**
     * Get all instances of referralRules
     *
     * @return ArrayCollection Collection of ReferralRule
     */
    public function findAll()
    {
        return new ArrayCollection(parent::findAll());
    }
}
