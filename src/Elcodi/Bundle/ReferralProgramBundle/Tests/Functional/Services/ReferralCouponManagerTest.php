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

namespace Elcodi\Bundle\ReferralProgramBundle\Tests\Functional\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramRuleTypes;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\Component\ReferralProgram\Entity\Invitation;
use Elcodi\Component\User\Entity\Customer;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;

/**
 * Class ReferralCouponManagerTest
 */
class ReferralCouponManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.manager.referral_coupon',
        ];
    }

    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
     */
    protected function loadFixturesBundles()
    {
        return array(
            'ElcodiUserBundle',
            'ElcodiReferralProgramBundle',
        );
    }

    /**
     * Tests coupon assignment
     *
     * History:
     * * Given an existing ReferralRule with Register Coupon for both
     * * Referrer and 1 random Customer adds invitation
     * * Checks invitations are OK
     * * Invited registers ( Event is thrown ) in site
     * * Both Customers receive coupons
     * * All coupons are for one use and have generated coupon names.
     */
    public function testCouponAssignmentRegReg()
    {
        /**
         * Enables right ReferralRule and disable all other
         */
        $this
            ->find('referral_rule', 1)
            ->disable();

        /**
         * @var ReferralRuleInterface $referralRule
         */
        $referralRule = $this->find('referral_rule', 2);

        $this
            ->get('elcodi.manager.referral_rule')
            ->enableReferralRule($referralRule);

        $invitations = new ArrayCollection();
        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('invited@invited.com')
            ->setName('Invited');
        $invitations->add($invitation1);

        $referralProgramManager = $this
            ->get('elcodi.manager.referral_program');

        $referralProgramManager->invite(
            $this->find('customer', 1),
            $invitations
        );

        $referralProgramManager->invite(
            $this->find('customer', 2),
            $invitations
        );

        /**
         * All lines are created
         */
        $this->assertCount(
            2,
            $this->findAll('referral_line')
        );

        /**
         * New customer is created with a referral hash in the cookie.
         *
         * @var ReferralHashInterface $referralHash
         */
        $referrer = $this->find('customer', 1);

        $referralHash = $this
            ->get('elcodi.manager.referral_hash')
            ->getReferralHashByCustomer($referrer);
        $hash = $referralHash->getHash();

        /**
         * @var CustomerInterface $newCustomer
         */
        $newCustomer = $this
            ->getFactory('customer')
            ->create();

        $newCustomer
            ->setPassword('customer3')
            ->setEmail('customer3@customer.com');

        $customerObjectManager = $this->getObjectManager('customer');
        $customerObjectManager->persist($newCustomer);
        $customerObjectManager->flush();
        $customerObjectManager->clear();

        $invited = $this->getRepository('customer')->findOneBy(array(
            'email' => 'customer3@customer.com',
        ));

        $referralCouponManager = $this
            ->get('elcodi.manager.referral_coupon');

        $referralCouponManager
            ->checkCouponAssignment(
                $invited,
                $hash,
                ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER
            );

        /**
         * All lines are disabled but the important one.
         *
         * @var ReferralLineInterface $desiredReferralLine
         */
        $desiredReferralLine = $this
            ->getRepository('referral_line')
            ->findOneByInvited($newCustomer);

        $this->assertTrue($desiredReferralLine->isEnabled());

        /**
         * @var Collection $referralLines
         */
        $referralLines = $this
            ->getRepository('referral_line')
            ->findByInvitedEmail($newCustomer->getEmail());

        $referralLines->removeElement($desiredReferralLine);

        /**
         * @var ReferralLineInterface $referralLine
         */
        foreach ($referralLines as $referralLine) {
            $this->assertFalse($referralLine->isEnabled());
        }

        /**
         * Both coupons should be created with a random code ( generated by generator )
         * Coupons must be different than original one.
         */
        $referrerAssignedCoupon = $desiredReferralLine->getReferrerAssignedCoupon();
        $this->assertInstanceOf('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface', $referrerAssignedCoupon);
        $this->assertEquals($referrerAssignedCoupon->getCount(), 1);
        $this->assertfalse($desiredReferralLine->getReferrerCouponUsed());
        $this->assertEquals(
            $desiredReferralLine->getReferralRule()->getReferrerCoupon()->getId(),
            $desiredReferralLine->getReferrerCoupon()->getId()
        );
        $this->assertNotEquals($referrerAssignedCoupon->getId(), $desiredReferralLine->getReferrerCoupon()->getId());

        $invitedCoupon = $desiredReferralLine->getInvitedAssignedCoupon();
        $this->assertInstanceOf('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface', $invitedCoupon);
        $this->assertEquals($invitedCoupon->getCount(), 1);
        $this->assertfalse($desiredReferralLine->getInvitedCouponUsed());
        $this->assertEquals(
            $desiredReferralLine->getReferralRule()->getInvitedCoupon()->getId(),
            $desiredReferralLine->getInvitedCoupon()->getId()
        );
        $this->assertNotEquals($invitedCoupon->getId(), $desiredReferralLine->getInvitedCoupon()->getId());
    }

    /**
     * Tests coupon assignment
     *
     * History:
     * * Given an existing ReferralRule with Register Coupon for referrer and
     *   purchase coupon for invited
     * * Referrer adds invitation
     * * Invited registers in site
     * * Referrer Customer receive coupons
     * * Invited customer purchases and receive his coupon
     * * Both purchases using their coupons
     * * ReferralRule is closed
     */
    public function testCouponAssignmentRegPurch()
    {
        /**
         * Enables right ReferralRule and disable all other
         */
        $this
            ->find('referral_rule', 1)
            ->disable();

        $referralRule = $this->find('referral_rule', 4);

        $this
            ->get('elcodi.manager.referral_rule')
            ->enableReferralRule($referralRule);

        $this
            ->getObjectManager('referral_rule')
            ->clear();

        /**
         * New customer is created with a referral hash in the cookie.
         *
         * @var ReferralHashInterface $referralHash
         */
        $referrer = $this->find('customer', 1);

        $invited = $this->find('customer', 2);

        $referralHash = $this
            ->get('elcodi.manager.referral_hash')
            ->getReferralHashByCustomer($referrer);
        $hash = $referralHash->getHash();

        $invitations = new ArrayCollection();
        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('invited@invited.com')
            ->setName('Invited');
        $invitations->add($invitation1);

        $this
            ->get('elcodi.manager.referral_program')
            ->invite($referrer, $invitations);

        /**
         * * Invited registers in site
         * * Referrer Customer receive coupons
         */
        $referralCouponManager = $this->get('elcodi.manager.referral_coupon');

        $referralCouponManager->checkCouponAssignment(
            $invited,
            $hash,
            ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER
        );

        $this
            ->getObjectManager('referral_rule')
            ->clear();

        /**
         * @var ReferralLineInterface $referralLine
         */
        $referralLine = $this
            ->getRepository('referral_line')
            ->findOneByInvited($invited);

        $referrerAssignedCoupon = $referralLine->getReferrerAssignedCoupon();
        $this->assertInstanceOf('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface', $referrerAssignedCoupon);
        $this->assertEquals($referrerAssignedCoupon->getCount(), 1);
        $this->assertfalse($referralLine->getReferrerCouponUsed());
        $this->assertEquals(
            $referralLine->getReferralRule()->getReferrerCoupon()->getId(),
            $referralLine->getReferrerCoupon()->getId()
        );
        $this->assertNotEquals($referrerAssignedCoupon->getId(), $referralLine->getReferrerCoupon()->getId());
        $this->assertNull($referralLine->getInvitedAssignedCoupon());
        $this->assertFalse($referralLine->getInvitedCouponUsed());
        $this->assertFalse($referralLine->isClosed());

        $this
            ->getObjectManager('referral_rule')
            ->clear();

        /**
         * * Invited customer purchases and receive his coupon
         */
        $invited = $this->find('customer', 2);

        $referralLine = $this
            ->getRepository('referral_line')
            ->findOneByInvited($invited);

        $referralCouponManager->checkCouponAssignment(
            $invited,
            $hash,
            ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE
        );
        $invitedAssignedCoupon = $referralLine->getInvitedAssignedCoupon();
        $this->assertInstanceOf('Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface', $invitedAssignedCoupon);
        $this->assertEquals($invitedAssignedCoupon->getCount(), 1);
        $this->assertfalse($referralLine->getInvitedCouponUsed());
        $this->assertEquals(
            $referralLine->getReferralRule()->getInvitedCoupon()->getId(),
            $referralLine->getInvitedCoupon()->getId()
        );
        $this->assertNotEquals($invitedAssignedCoupon->getId(), $referralLine->getInvitedCoupon()->getId());
        $this->assertFalse($referralLine->isClosed());

        $this
            ->getObjectManager('referral_rule')
            ->clear();

        /**
         * Referrer Customer buys using his coupon
         */
        $referrer = $this->find('customer', 1);

        $invited = $this->find('customer', 2);

        $referralLine = $this
            ->getRepository('referral_line')
            ->findOneByInvited($invited);

        $referralCouponManager
            ->checkCouponAssignment($referrer, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->checkCouponsUsed($referrer, new ArrayCollection(array($referralLine->getReferrerAssignedCoupon())));

        $this->assertTrue($referralLine->getReferrerCouponUsed());
        $this->assertFalse($referralLine->isClosed());

        $this
            ->getObjectManager('referral_rule')
            ->clear();

        /**
         * Invited Customer buys using his coupon
         * ReferralLine is closed
         */
        $invited = $this->find('customer', 2);

        $referralLine = $this
            ->getRepository('referral_line')
            ->findOneByInvited($invited);

        $referralCouponManager
            ->checkCouponAssignment($invited, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->checkCouponsUsed($invited, new ArrayCollection(array($referralLine->getInvitedAssignedCoupon())));

        $this->assertTrue($referralLine->getInvitedCouponUsed());
        $this->assertTrue($referralLine->isClosed());
    }
}
