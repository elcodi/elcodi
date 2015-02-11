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

namespace Elcodi\Bundle\ReferralProgramBundle\DataFixtures\ORM;

use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;
use Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramRuleTypes;
use Elcodi\Component\ReferralProgram\Factory\ReferralRuleFactory;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralProgram
 */
class ReferralProgramData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var ReferralRuleFactory $referralRuleFactory
         * @var CouponInterface     $coupon
         * @var CustomerInterface   $customer
         */
        $referralRuleFactory = $this->getFactory('referral_rule');
        $referralHashFactory = $this->getFactory('referral_hash');
        $referralRuleObjectManager = $this->getObjectManager('referral_rule');
        $referralHashObjectManager = $this->getObjectManager('referral_hash');
        $coupon = $this->getReference('coupon-percent');
        $customer = $this->getReference('customer-1');

        /**
         * Referral Rule: ReferrerCoupon NO, InvitedCoupon NO
         */
        $referralRuleNoNO = $referralRuleFactory
            ->create()
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON)
            ->setValidFrom(new DateTime())
            ->enable();

        $referralRuleObjectManager->persist($referralRuleNoNO);
        $this->addReference('referral-rule-no-no', $referralRuleNoNO);

        /**
         * Referral Rule: ReferrerCoupon Register, InvitedCoupon Register
         */
        $referralRuleRegReg = $referralRuleFactory
            ->create()
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime())
            ->disable();

        $referralRuleObjectManager->persist($referralRuleRegReg);
        $this->addReference('referral-rule-reg-reg', $referralRuleRegReg);

        /**
         * Referral Rule: ReferrerCoupon Purchase, InvitedCoupon Purchase
         */
        $referralRulePurchPurch = $referralRuleFactory
            ->create()
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime())
            ->disable();

        $referralRuleObjectManager->persist($referralRulePurchPurch);
        $this->addReference('referral-rule-purch-purch', $referralRulePurchPurch);

        /**
         * Referral Rule: ReferrerCoupon Purchase, InvitedCoupon Purchase
         */
        $referralRuleRegPurch = $referralRuleFactory
            ->create()
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime())
            ->disable();

        $referralRuleObjectManager->persist($referralRuleRegPurch);
        $this->addReference('referral-rule-reg-purch', $referralRuleRegPurch);

        $referralRuleObjectManager->flush([
            $referralRuleNoNO,
            $referralRuleRegReg,
            $referralRulePurchPurch,
            $referralRuleRegPurch,
        ]);

        /**
         * Referral Hash
         */
        $referralHash = $referralHashFactory
            ->create()
            ->setReferrer($customer)
            ->setHash('1234567890');

        $referralHashObjectManager->persist($referralHash);
        $this->addReference('referral-hash', $referralHash);

        $referralHashObjectManager->flush([
            $referralHash,
        ]);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'Elcodi\Bundle\UserBundle\DataFixtures\ORM\CustomerData',
            'Elcodi\Bundle\CouponBundle\DataFixtures\ORM\CouponData',
        ];
    }
}
