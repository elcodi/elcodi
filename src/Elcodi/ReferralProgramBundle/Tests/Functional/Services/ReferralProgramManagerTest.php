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

use Elcodi\ReferralProgramBundle\ElcodiReferralProgramRuleTypes;
use Elcodi\ReferralProgramBundle\ElcodiReferralProgramSources;
use Elcodi\ReferralProgramBundle\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\ReferralProgramBundle\Entity\ReferralHash;
use Elcodi\ReferralProgramBundle\Entity\ReferralLine;
use Elcodi\ReferralProgramBundle\Entity\ReferralRule;
use Elcodi\ReferralProgramBundle\Model\Invitation;
use Elcodi\CoreBundle\Tests\WebTestCase;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ReferralProgramManagerTest
 */
class ReferralProgramManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string service name
     */
    public function getServiceCallableName()
    {
        return 'elcodi.core.referral_program.services.referral_program_manager';
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
     * Test bulk invitation
     *
     * History: A set of users are invited into referralprogram engine.
     * A new customer is used, so related ReferralHash unexists
     */
    public function testInvite()
    {
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');
        $referralProgramManager = $container->get($this->getServiceCallableName());
        $referrer = $manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $referralRule = $manager->getRepository('ElcodiReferralProgramBundle:ReferralRule')->find(1);

        $invitations = new ArrayCollection;

        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('user@email.com')
            ->setName('User Name');
        $invitations->add($invitation1);

        $invitation2 = new Invitation();
        $invitation2
            ->setEmail('user2@email.com')
            ->setName('User2 Name');
        $invitations->add($invitation2);

        $invitation3 = new Invitation();
        $invitation3
            ->setEmail('user3@email.com')
            ->setName('');
        $invitations->add($invitation3);

        $invitation4 = new Invitation();
        $invitation4
            ->setEmail('user4@email.com')
            ->setName(false);
        $invitations->add($invitation4);

        $invitation5 = new Invitation();
        $invitation5
            ->setEmail('use5r@email.com')
            ->setName(null);
        $invitations->add($invitation5);

        $referralProgramManager->invite(
            $referrer,
            $invitations
        );

        /**
         * @var $referralHash ReferralHash
         */
        $referralHash = $manager
            ->getRepository('ElcodiReferralProgramBundle:ReferralHash')
            ->findOneBy(array(
                'referrer' => $referrer,
            ));

        /**
         * @var $referralLine ReferralLine
         */
        $referralLines = $manager
            ->getRepository('ElcodiReferralProgramBundle:ReferralLine')
            ->findBy(array(
                'referralHash' => $referralHash,
            ));

        $this->assertCount(5, $referralLines);
        foreach ($referralLines as $referralLine) {

            $this->assertInstanceOf('Elcodi\ReferralProgramBundle\Entity\ReferralLine', $referralLine);
            $this->assertNull($referralLine->getInvited());
            $this->assertEquals($referralLine->getSource(), ElcodiReferralProgramSources::EMAIL);
            $this->assertEquals($referralLine->getReferralRule()->getId(), $referralRule->getId());
            $this->assertFalse($referralLine->getReferrerCouponUsed());
            $this->assertFalse($referralLine->getInvitedCouponUsed());
            $this->assertNull($referralLine->getReferrerCoupon());
            $this->assertNull($referralLine->getInvitedCoupon());
            $this->assertEquals($referralLine->getReferrerType(), ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON);
            $this->assertEquals($referralLine->getInvitedType(), ElcodiReferralProgramRuleTypes::TYPE_WITHOUT_COUPON);

            $referralHash = $referralLine->getReferralHash();
            $this->assertEquals($referralHash->getReferrer()->getId(), $referrer->getId());
            $this->assertNotEmpty($referralHash->getHash());
        }
    }

    /**
     * Test simple invitation without any enabled ReferralRule
     *
     * History: An email is invited using referralprogram engine.
     * No ReferralRule is enabled
     *
     * @expectedException \Elcodi\ReferralProgramBundle\Exceptions\ReferralProgramRuleNotFoundException
     */
    public function testInviteNoReferralHashEnabled()
    {
        $container = static::$kernel->getContainer();
        $manager = $container->get('doctrine.orm.entity_manager');
        $referralProgramManager = $container->get($this->getServiceCallableName());
        $referrer = $manager->getRepository('ElcodiUserBundle:Customer')->find(1);
        $referralRules = $manager->getRepository('ElcodiReferralProgramBundle:ReferralRule')->findAll();
        $referralRules->map(function ($referralRule) {

            /**
             * @var ReferralRuleInterface $referralRule
             */
            $referralRule->setEnabled(false);
        });
        $manager->flush();
        $manager->clear();

        $invitations = new ArrayCollection();

        $invitation1 = new Invitation();
        $invitation1
            ->setEmail('user@email.com')
            ->setName('User Name');
        $invitations->add($invitation1);

        $referralProgramManager->invite(
            $referrer,
            $invitations
        );
    }
}
