<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author ##author_placeholder
 * @version ##version_placeholder##
 */

namespace Elcodi\ReferralProgramBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

use Elcodi\CouponBundle\Entity\Interfaces\CouponInterface;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\ReferralProgramBundle\ElcodiReferralProgramRuleTypes;
use Elcodi\CoreBundle\DataFixtures\ORM\Abstracts\AbstractFixture;

/**
 * Class ReferralProgram
 */
class ReferralProgramData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Referral Rule: ReferrerCoupon NO, InvitedCoupon NO
         */
        $referralRuleNoNO = $this->container->get('elcodi.core.referral_program.factory.referralrule')->create();
        $referralRuleNoNO
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON)
            ->setValidFrom(new DateTime)
            ->enable();

        /**
         * @var CouponInterface $coupon
         */
        $coupon = $this->getReference('coupon-percent');

        /**
         * Referral Rule: ReferrerCoupon Register, InvitedCoupon Register
         */
        $referralRuleRegReg = $this->container->get('elcodi.core.referral_program.factory.referralrule')->create();
        $referralRuleRegReg
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime)
            ->disable();

        /**
         * Referral Rule: ReferrerCoupon Purchase, InvitedCoupon Purchase
         */
        $referralRulePurchPurch = $this->container->get('elcodi.core.referral_program.factory.referralrule')->create();
        $referralRulePurchPurch
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime)
            ->disable();

        /**
         * Referral Rule: ReferrerCoupon Purchase, InvitedCoupon Purchase
         */
        $referralRuleRegPurch = $this->container->get('elcodi.core.referral_program.factory.referralrule')->create();
        $referralRuleRegPurch
            ->setReferrerType(ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER)
            ->setReferrerCoupon($coupon)
            ->setInvitedType(ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->setInvitedCoupon($coupon)
            ->setValidFrom(new DateTime)
            ->disable();

        /**
         * Referral Hash
         */

        /**
         * @var CustomerInterface $customer
         */
        $customer = $this->getReference('customer-1');
        $referralHash = $this->container->get('elcodi.core.referral_program.factory.referralhash')->create();
        $referralHash
            ->setReferrer($customer)
            ->setHash('1234567890');

        $manager->persist($referralRuleNoNO);
        $manager->persist($referralRuleRegReg);
        $manager->persist($referralRulePurchPurch);
        $manager->persist($referralRuleRegPurch);
        $manager->persist($referralHash);
        $manager->flush();

        $this->addReference('referral-rule-no-no', $referralRuleNoNO);
        $this->addReference('referral-rule-reg-reg', $referralRuleRegReg);
        $this->addReference('referral-rule-purch-purch', $referralRulePurchPurch);
        $this->addReference('referral-rule-reg-purch', $referralRuleRegPurch);
        $this->addReference('referral-hash', $referralHash);
    }

    /**
     * Order for given fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 128;
    }
}
