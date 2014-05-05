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

namespace Elcodi\ReferralProgramBundle\Tests\Functional\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Elcodi\ReferralProgramBundle\ElcodiReferralProgramRuleTypes;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralHashInterface;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralLineInterface;
use Elcodi\ReferralProgramBundle\Model\Invitation;
use Elcodi\UserBundle\Entity\Customer;
use Elcodi\CoreBundle\Tests\WebTestCase;

/**
 * Class ReferralCouponManagerTest
 */
class ReferralCouponManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.referral_program.services.referral_coupon_manager';
    }

    /**
     * Load fixtures of these bundles
     *
     * @return array Bundles name where fixtures should be found
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
            'ElcodiCoreBundle',
            'ElcodiUserBundle',
            'ElcodiCouponBundle',
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
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');

        /**
         * Enables right ReferralRule and disable all other
         */
        $manager->getRepository('ElcodiReferralProgramBundle:ReferralRule')->find(1)->disable();
        $referralRule = $manager
            ->getRepository('ElcodiReferralProgramBundle:ReferralRule')
            ->find(2);
        $container
            ->get('elcodi.core.referral_program.services.referral_rule_manager')
            ->enableReferralRule($referralRule);

        $invitations = new ArrayCollection;
        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('invited@invited.com')
            ->setName('Invited');
        $invitations->add($invitation1);

        $referralProgramManager = $container
            ->get('elcodi.core.referral_program.services.referral_program_manager');

        $referralProgramManager->invite(
            $manager->getRepository('ElcodiUserBundle:Customer')->find(1),
            $invitations
        );

        $referralProgramManager->invite(
            $manager->getRepository('ElcodiUserBundle:Customer')->find(2),
            $invitations
        );

        /**
         * All lines are created
         */
        $this->assertCount(2, $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findAll());

        /**
         * New customer is created with a referral hash in the cookie.
         *
         * @var ReferralHashInterface $referralHash
         */
        $referrer = $manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $referralHash = $container
            ->get('elcodi.core.referral_program.services.referral_hash_manager')
            ->getReferralHashByCustomer($referrer);
        $hash = $referralHash->getHash();

        $newCustomer = $this->container->get('elcodi.core.user.factory.customer')->create();
        $newCustomer
            ->setUsername('customer3')
            ->setPassword('customer3')
            ->setEmail('customer3@customer.com');
        $manager->persist($newCustomer);
        $manager->flush();
        $manager->clear();

        $invited = $manager->getRepository('ElcodiUserBundle:Customer')->findOneBy(array(
            'email' => 'customer3@customer.com'
        ));

        $referralCouponManager = $container->get('elcodi.core.referral_program.services.referral_coupon_manager');
        $referralCouponManager->checkCouponAssignment($invited, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER);

        /**
         * All lines are disabled but the important one.
         *
         * @var ReferralLineInterface $desiredReferralLine
         */
        $desiredReferralLine = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findOneByInvited($newCustomer);
        $this->assertTrue($desiredReferralLine->isEnabled());

        /**
         * @var Collection $referralLines
         */
        $referralLines = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findByInvitedEmail($newCustomer->getEmail());
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
        $this->assertInstanceOf('Elcodi\CouponBundle\Entity\Interfaces\CouponInterface', $referrerAssignedCoupon);
        $this->assertEquals($referrerAssignedCoupon->getCount(), 1);
        $this->assertfalse($desiredReferralLine->getReferrerCouponUsed());
        $this->assertEquals($desiredReferralLine->getReferralRule()->getReferrerCoupon()->getId(), $desiredReferralLine->getReferrerCoupon()->getId());
        $this->assertNotEquals($referrerAssignedCoupon->getId(), $desiredReferralLine->getReferrerCoupon()->getId());

        $invitedCoupon = $desiredReferralLine->getInvitedAssignedCoupon();
        $this->assertInstanceOf('Elcodi\CouponBundle\Entity\Interfaces\CouponInterface', $invitedCoupon);
        $this->assertEquals($invitedCoupon->getCount(), 1);
        $this->assertfalse($desiredReferralLine->getInvitedCouponUsed());
        $this->assertEquals($desiredReferralLine->getReferralRule()->getInvitedCoupon()->getId(), $desiredReferralLine->getInvitedCoupon()->getId());
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
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');

        /**
         * Enables right ReferralRule and disable all other
         */
        $manager->getRepository('ElcodiReferralProgramBundle:ReferralRule')->find(1)->disable();
        $referralRule = $manager
            ->getRepository('ElcodiReferralProgramBundle:ReferralRule')
            ->find(4);
        $container
            ->get('elcodi.core.referral_program.services.referral_rule_manager')
            ->enableReferralRule($referralRule);

        $manager->clear();

        /**
         * New customer is created with a referral hash in the cookie.
         *
         * @var ReferralHashInterface $referralHash
         */
        $referrer = $manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $invited = $manager->getRepository('ElcodiUserBundle:Customer')->find(2);
        $referralHash = $container
            ->get('elcodi.core.referral_program.services.referral_hash_manager')
            ->getReferralHashByCustomer($referrer);
        $hash = $referralHash->getHash();

        $invitations = new ArrayCollection;
        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('invited@invited.com')
            ->setName('Invited');
        $invitations->add($invitation1);

        $container
            ->get('elcodi.core.referral_program.services.referral_program_manager')
            ->invite($referrer, $invitations);

        /**
         * * Invited registers in site
         * * Referrer Customer receive coupons
         */
        $referralCouponManager = $container->get('elcodi.core.referral_program.services.referral_coupon_manager');
        $referralCouponManager->checkCouponAssignment($invited, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_REGISTER);

        $manager->clear();

        /**
         * @var ReferralLineInterface $referralLine
         */
        $referralLine = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findOneByInvited($invited);
        $referrerAssignedCoupon = $referralLine->getReferrerAssignedCoupon();
        $this->assertInstanceOf('Elcodi\CouponBundle\Entity\Interfaces\CouponInterface', $referrerAssignedCoupon);
        $this->assertEquals($referrerAssignedCoupon->getCount(), 1);
        $this->assertfalse($referralLine->getReferrerCouponUsed());
        $this->assertEquals($referralLine->getReferralRule()->getReferrerCoupon()->getId(), $referralLine->getReferrerCoupon()->getId());
        $this->assertNotEquals($referrerAssignedCoupon->getId(), $referralLine->getReferrerCoupon()->getId());
        $this->assertNull($referralLine->getInvitedAssignedCoupon());
        $this->assertFalse($referralLine->getInvitedCouponUsed());
        $this->assertFalse($referralLine->isClosed());

        $manager->clear();

        /**
         * * Invited customer purchases and receive his coupon
         */
        $invited = $manager->getRepository('ElcodiUserBundle:Customer')->find(2);
        $referralLine = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findOneByInvited($invited);

        $referralCouponManager->checkCouponAssignment($invited, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE);
        $invitedAssignedCoupon = $referralLine->getInvitedAssignedCoupon();
        $this->assertInstanceOf('Elcodi\CouponBundle\Entity\Interfaces\CouponInterface', $invitedAssignedCoupon);
        $this->assertEquals($invitedAssignedCoupon->getCount(), 1);
        $this->assertfalse($referralLine->getInvitedCouponUsed());
        $this->assertEquals($referralLine->getReferralRule()->getInvitedCoupon()->getId(), $referralLine->getInvitedCoupon()->getId());
        $this->assertNotEquals($invitedAssignedCoupon->getId(), $referralLine->getInvitedCoupon()->getId());
        $this->assertFalse($referralLine->isClosed());

        $manager->clear();

        /**
         * Referrer Customer buys using his coupon
         */
        $referrer = $manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $invited = $manager->getRepository('ElcodiUserBundle:Customer')->find(2);
        $referralLine = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findOneByInvited($invited);
        $referralCouponManager
            ->checkCouponAssignment($referrer, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->checkCouponsUsed($referrer, new ArrayCollection(array($referralLine->getReferrerAssignedCoupon())));

        $this->assertTrue($referralLine->getReferrerCouponUsed());
        $this->assertFalse($referralLine->isClosed());

        $manager->clear();

        /**
         * Invited Customer buys using his coupon
         * ReferralLine is closed
         */
        $invited = $manager->getRepository('ElcodiUserBundle:Customer')->find(2);
        $referralLine = $manager->getRepository('ElcodiReferralProgramBundle:ReferralLine')->findOneByInvited($invited);

        $referralCouponManager
            ->checkCouponAssignment($invited, $hash, ElcodiReferralProgramRuleTypes::TYPE_ON_FIRST_PURCHASE)
            ->checkCouponsUsed($invited, new ArrayCollection(array($referralLine->getInvitedAssignedCoupon())));

        $this->assertTrue($referralLine->getInvitedCouponUsed());
        $this->assertTrue($referralLine->isClosed());
    }
}
