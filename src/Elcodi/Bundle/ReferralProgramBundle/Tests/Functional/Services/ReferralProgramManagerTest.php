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
use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramRuleTypes;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramSources;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\Component\ReferralProgram\Entity\Invitation;
use Elcodi\Component\ReferralProgram\Entity\ReferralHash;
use Elcodi\Component\ReferralProgram\Entity\ReferralLine;
use Elcodi\Component\ReferralProgram\Entity\ReferralRule;

/**
 * Class ReferralProgramManagerTest
 */
class ReferralProgramManagerTest extends WebTestCase
{
    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.manager.referral_program',
            'elcodi.referral_program',
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
            'ElcodiLanguageBundle',
            'ElcodiUserBundle',
            'ElcodiCurrencyBundle',
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
        $referralProgramManager = $this->get('elcodi.referral_program');
        $referrer = $this->find('customer', 1);
        $referralRule = $this->find('referral_rule', 1);

        $invitations = new ArrayCollection();

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
        $referralHash = $this
            ->getRepository('referral_hash')
            ->findOneBy(array(
                'referrer' => $referrer,
            ));

        /**
         * @var $referralLine ReferralLine
         */
        $referralLines = $this
            ->getRepository('referral_line')
            ->findBy(array(
                'referralHash' => $referralHash,
            ));

        $this->assertCount(5, $referralLines);
        foreach ($referralLines as $referralLine) {
            $this->assertInstanceOf('Elcodi\Component\ReferralProgram\Entity\ReferralLine', $referralLine);
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
     * @expectedException \Elcodi\Component\ReferralProgram\Exceptions\ReferralProgramRuleNotFoundException
     */
    public function testInviteNoReferralHashEnabled()
    {
        /**
         * @var ObjectManager $referralRuleManager
         */
        $referralRuleManager = $this->getObjectManager('referral_rule');
        $referralProgramManager = $this->get('elcodi.referral_program');
        $referrer = $this->find('customer', 1);
        $referralRules = $this->findAll('referral_rule');
        $referralRules->map(function ($referralRule) {

            /**
             * @var ReferralRuleInterface $referralRule
             */
            $referralRule->setEnabled(false);
        });
        $referralRuleManager->flush();
        $referralRuleManager->clear();

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
