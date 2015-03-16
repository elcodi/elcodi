<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
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

namespace Elcodi\Component\ReferralProgram\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface;
use Elcodi\Component\ReferralProgram\Entity\ReferralHash;
use Elcodi\Component\ReferralProgram\Factory\ReferralHashFactory;
use Elcodi\Component\ReferralProgram\Repository\ReferralHashRepository;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralHashManager
 *
 * This service is the responsible for creating and managing all ReferralHash
 * instances of ReferralProgram model
 */
class ReferralHashManager
{
    /**
     * @var ReferralHashRepository
     *
     * referralHashRepository
     */
    protected $referralHashRepository;

    /**
     * @var ObjectManager
     *
     * manager
     */
    protected $manager;

    /**
     * @var GeneratorInterface
     *
     * referralHashGenerator
     */
    protected $referralHashGenerator;

    /**
     * @var ReferralHashFactory
     *
     * ReferralHash factory
     */
    protected $referralHashFactory;

    /**
     * Construct method
     *
     * @param ReferralHashRepository $referralHashRepository ReferralHash repository
     * @param ObjectManager          $manager                Manager
     * @param GeneratorInterface     $referralHashGenerator  ReferralHash generator
     * @param ReferralHashFactory    $referralHashFactory    ReferralHash factory
     */
    public function __construct(
        ReferralHashRepository $referralHashRepository,
        ObjectManager $manager,
        GeneratorInterface $referralHashGenerator,
        ReferralHashFactory $referralHashFactory
    ) {
        $this->referralHashRepository = $referralHashRepository;
        $this->manager = $manager;
        $this->referralHashGenerator = $referralHashGenerator;
        $this->referralHashFactory = $referralHashFactory;
    }

    /**
     * Given an existing Customer, this service manages its referral hash
     *
     * When requiring Customer Hash, if not set, new one is generated.
     * Otherwise, returns related.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return ReferralHash ReferralHash
     */
    public function getReferralHashByCustomer(CustomerInterface $customer)
    {
        /**
         * @var $referralHash ReferralHash
         */
        $referralHash = $this->referralHashRepository->findOneBy(array(
            'referrer' => $customer,
        ));

        if (!($referralHash instanceof ReferralHashInterface)) {
            $referralHash = $this->referralHashFactory->create();
            $referralHash
                ->setReferrer($customer)
                ->setHash($this->referralHashGenerator->generate());

            $this->manager->persist($referralHash);
            $this->manager->flush($referralHash);
        }

        return $referralHash;
    }

    /**
     * Given a hash, returns related ReferralHash
     * If none, return null
     *
     * @param string $hash Hash
     *
     * @return ReferralHash|null
     */
    public function getReferralHashByHash($hash)
    {
        return $this->referralHashRepository->findOneBy(array(
            'hash' => $hash,
        ));
    }
}
