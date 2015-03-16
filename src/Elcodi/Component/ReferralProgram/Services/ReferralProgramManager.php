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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Elcodi\Component\ReferralProgram\ElcodiReferralProgramEvents;
use Elcodi\Component\ReferralProgram\ElcodiReferralProgramSources;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\InvitationBagInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\InvitationInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralHashInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralLineInterface;
use Elcodi\Component\ReferralProgram\Entity\Interfaces\ReferralRuleInterface;
use Elcodi\Component\ReferralProgram\Entity\ReferralHash;
use Elcodi\Component\ReferralProgram\Entity\ReferralLine;
use Elcodi\Component\ReferralProgram\Entity\ReferralRule;
use Elcodi\Component\ReferralProgram\Event\ReferralProgramInvitationEvent;
use Elcodi\Component\ReferralProgram\Exceptions\ReferralProgramEmailIsUserException;
use Elcodi\Component\ReferralProgram\Exceptions\ReferralProgramLineExistsException;
use Elcodi\Component\ReferralProgram\Exceptions\ReferralProgramRuleNotFoundException;
use Elcodi\Component\ReferralProgram\Factory\InvitationBagFactory;
use Elcodi\Component\ReferralProgram\Factory\InvitationFactory;
use Elcodi\Component\ReferralProgram\Factory\ReferralLineFactory;
use Elcodi\Component\ReferralProgram\Repository\ReferralLineRepository;
use Elcodi\Component\ReferralProgram\Repository\ReferralRuleRepository;
use Elcodi\Component\User\Entity\Customer;
use Elcodi\Component\User\Entity\Interfaces\CustomerInterface;
use Elcodi\Component\User\Repository\CustomerRepository;

/**
 * Class ReferralProgramManager
 */
class ReferralProgramManager
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var ReferralRuleRepository
     *
     * ReferralRule Repository
     */
    protected $referralRuleRepository;

    /**
     * @var ReferralLineRepository
     *
     * ReferralLine Repository
     */
    protected $referralLineRepository;

    /**
     * @var ObjectManager
     *
     * manager
     */
    protected $manager;

    /**
     * @var ReferralRouteManager
     *
     * ReferralRouteManager
     */
    protected $referralRouteManager;

    /**
     * @var ReferralHashManager
     *
     * ReferralHash manager
     */
    protected $referralHashManager;

    /**
     * @var string
     *
     * Multiple invitations policy
     */
    protected $multipleInvitationsPolicy;

    /**
     * @var ReferralLineFactory
     *
     * ReferralLine factory
     */
    protected $referralLineFactory;

    /**
     * @var InvitationBagFactory
     *
     * InvitationBag factory
     */
    protected $invitationBagFactory;

    /**
     * @var boolean
     *
     * Purge disabled lines
     */
    protected $purgeDisabledLines;
    /**
     * @var \Elcodi\Component\ReferralProgram\Factory\InvitationFactory
     *
     * invitationFactory
     */
    protected $invitationFactory;
    /**
     * @var \Elcodi\Component\User\Repository\CustomerRepository
     *
     * customerRepository
     */
    protected $customerRepository;

    /**
     * @var boolean
     *
     * Auto referral assignment
     */
    protected $autoReferralAssignment;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface $eventDispatcher        Event dispatcher
     * @param ReferralRuleRepository   $referralRuleRepository Referralrule repository
     * @param ReferralLineRepository   $referralLineRepository Referralline repository
     * @param ObjectManager            $manager                Manager
     * @param ReferralRouteManager     $referralRouteManager   Referral route manager
     * @param ReferralHashManager      $referralHashManager    ReferralHash manager
     * @param ReferralLineFactory      $referralLineFactory    ReferralLine factory
     * @param InvitationBagFactory     $invitationBagFactory   InvitationBag factory
     * @param InvitationFactory        $invitationFactory      Invitation factory
     * @param CustomerRepository       $customerRepository     Customer repository
     * @param boolean                  $purgeDisabledLines     Purge disabled lines
     * @param boolean                  $autoReferralAssignment Auto Referral Assignment
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ReferralRuleRepository $referralRuleRepository,
        ReferralLineRepository $referralLineRepository,
        ObjectManager $manager,
        ReferralRouteManager $referralRouteManager,
        ReferralHashManager $referralHashManager,
        ReferralLineFactory $referralLineFactory,
        InvitationBagFactory $invitationBagFactory,
        InvitationFactory $invitationFactory,
        CustomerRepository $customerRepository,
        $purgeDisabledLines,
        $autoReferralAssignment
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->referralRuleRepository = $referralRuleRepository;
        $this->referralLineRepository = $referralLineRepository;
        $this->manager = $manager;
        $this->referralRouteManager = $referralRouteManager;
        $this->referralHashManager = $referralHashManager;
        $this->referralLineFactory = $referralLineFactory;
        $this->invitationBagFactory = $invitationBagFactory;
        $this->invitationFactory = $invitationFactory;
        $this->customerRepository = $customerRepository;
        $this->purgeDisabledLines = $purgeDisabledLines;
        $this->autoReferralAssignment = $autoReferralAssignment;
    }

    /**
     * Given an array of invited emails, create all ReferralLines
     *
     * invited emails is an associative array where key is email and value is
     * name of invited
     *
     * @param CustomerInterface $referrer    Referrer
     * @param Collection        $invitations Set of invitation instances
     *
     * @return InvitationBagInterface InvitationBag Object
     *
     * @throws ReferralProgramRuleNotFoundException
     */
    public function invite(CustomerInterface $referrer, Collection $invitations)
    {
        $referralRule = $this
            ->referralRuleRepository
            ->findEnabledReferralRule();

        /**
         * If any referral rule is defined, throw exception
         */
        if (!($referralRule instanceof ReferralRule)) {
            throw new ReferralProgramRuleNotFoundException();
        }

        /**
         * @var InvitationBagInterface $invitationBag
         */
        $invitationBag = $this->invitationBagFactory->create();

        foreach ($invitations as $invitation) {
            if ($invitation instanceof InvitationInterface) {
                try {
                    $source = $invitation->getSource()
                        ? $invitation->getSource()
                        : ElcodiReferralProgramSources::EMAIL;

                    $invitation = $this
                        ->invitationFactory
                        ->create()
                        ->setEmail($invitation->getEmail())
                        ->setName($invitation->getName())
                        ->setSource($source);

                    $this->inviteLine(
                        $referralRule,
                        $referrer,
                        $invitation
                    );

                    $invitationBag->addSentInvitation($invitation);
                } catch (ReferralProgramLineExistsException $e) {
                    $invitationBag->addErrorInvitation($invitation);
                } catch (ReferralProgramEmailIsUserException $e) {
                    $invitationBag->addErrorInvitation($invitation);
                }
            }
        }

        return $invitationBag;
    }

    /**
     * Resolve a customer in referral program engine.
     *
     * If given hash is empty or not exists, if ReferralRule
     * $autoReferralAssignment field is set to false, return null. If is set to
     * true and there is one, and only one ReferralLine with desired Customer
     * email, this Line will be taken.
     *
     * Otherwise, system tries to find referral line related to invitation.
     * If exists, return related ReferralLine
     * If not, new Direct ReferralLine is created
     *
     * In both cases, current customer is set as Invited element in line.
     *
     * This method do not flush changes.
     *
     * @param CustomerInterface $invited Customer
     * @param string            $hash    Hash
     *
     * @return ReferralHashInterface|null Related Referral Line
     */
    public function resolve(CustomerInterface $invited, $hash)
    {
        /**
         * Possibilities to get a referralLine
         *
         * * Hash belongs to an active ReferralHash containing given email
         * * Hash belongs to an active ReferralHash, but email is not inserted
         * * Hash do not belongs to any active ReferralHash or is empty, but
         *   given email is contained into one, and only one ReferralLine, and
         *   $autoReferralAssignment value is true
         * * Hash do not belongs to any active ReferralHash or is empty, but
         *   given email is contained into one active referral line
         *
         * @var $referralHash ReferralHash
         */
        $invitedEmail = $invited->getEmail();
        $referralHash = $this
            ->referralHashManager
            ->getReferralHashByHash($hash);

        if (!($referralHash instanceof ReferralHashInterface)) {
            $referralLines = new ArrayCollection();
            $referralLine = $this
                ->referralLineRepository
                ->findOneBy(array(
                    'enabled'      => true,
                    'closed'       => false,
                    'invitedEmail' => $invitedEmail,
                ));

            if (!($referralLine instanceof ReferralLineInterface)) {

                /**
                 * Only tries to retrieve current Line if
                 * $autoReferralAssignment is true
                 */
                if (!$this->autoReferralAssignment) {
                    return;
                }

                $referralLines = $this
                    ->referralLineRepository
                    ->findBy(array(
                        'closed'       => false,
                        'invitedEmail' => $invitedEmail,
                    ));

                /**
                 * No result is found or more than one. It means than this user
                 * is not invited and the hash is trying to use is not valid.
                 */
                if (!($referralLines instanceof ArrayCollection) || $referralLines->count() > 1) {
                    return;
                }

                $referralLine = $referralLines->first();
            }
        } else {

            /**
             * @var ArrayCollection $referralLines
             */
            $referralLines = $this
                ->referralLineRepository
                ->findByInvitedEmail($invitedEmail);

            /**
             * @var ReferralLine $referralLine
             */
            $referralLine = $this
                ->referralLineRepository
                ->findOneByReferralHashAndInvitedEmail($referralHash, $invited->getEmail());
        }

        /**
         * @var ArrayCollection $otherReferralLines
         */
        $manager = $this->manager;
        $purgeDisabledLines = $this->purgeDisabledLines;

        if (!$referralLines->isEmpty()) {
            $referralLines->removeElement($referralLine);
            $referralLines->map(function (ReferralLineInterface $otherReferralLine) use ($purgeDisabledLines, $manager) {

                if ($purgeDisabledLines) {
                    $manager->remove($otherReferralLine);
                } else {
                    $otherReferralLine->setEnabled(false);
                }
            });
        }

        /**
         * ReferralLine is not created, so we create new one with type direct
         */
        if (!($referralLine instanceof ReferralLineInterface)) {
            $referralRule = $this
                ->referralRuleRepository
                ->findEnabledReferralRule();

            if (!($referralRule instanceof ReferralRuleInterface)) {
                return;
            }

            $referralLine = $this->referralLineFactory->create();
            $referralLine
                ->setReferralHash($referralHash)
                ->setInvitedEmail($invited->getEmail())
                ->setInvitedName($invited->getFullName())
                ->setSource(ElcodiReferralProgramSources::DIRECT)
                ->setReferralRule($referralRule)
                ->setReferrerType($referralRule->getReferrerType())
                ->setReferrerCoupon($referralRule->getReferrerCoupon())
                ->setInvitedType($referralRule->getInvitedType())
                ->setInvitedCoupon($referralRule->getInvitedCoupon());

            $this->manager->persist($referralLine);
        }

        $referralLine
            ->setInvited($invited)
            ->setEnabled(true);
        $this->manager->flush();

        return $referralLine;
    }

    /**
     * Adds a user into de referral program table, given the Referrer Customer,
     * the invited email and the invited Name
     *
     * If current email is currently inserted in the table with enabled flag and
     * purgeInvalidLines is also set as true, Line will not be inserted.
     *
     * @param ReferralRuleInterface $referralRule ReferralRule
     * @param CustomerInterface     $referrer     Referrer
     * @param InvitationInterface   $invitation   Invitation
     *
     * @throws ReferralProgramEmailIsUserException
     * @throws ReferralProgramLineExistsException
     *
     * @return $this Self object
     */
    protected function inviteLine(
        ReferralRuleInterface $referralRule,
        CustomerInterface $referrer,
        InvitationInterface $invitation
    ) {
        $referralHash = $this
            ->referralHashManager
            ->getReferralHashByCustomer($referrer);

        /**
         * If purgeInvalidLines is enabled, we try to find if any ReferralLine
         * is enabled. If it is, we skip this email.
         */
        if ($this->purgeDisabledLines) {
            $enabledReferralLine = $this->referralLineRepository->findOneBy(array(
                'enabled'      => true,
                'invitedEmail' => $invitation->getEmail(),
            ));

            if ($enabledReferralLine instanceof ReferralLineInterface) {
                return $this;
            }
        }

        /**
         * @var ReferralLine $referralLine
         */
        $referralLine = $this
            ->referralLineRepository
            ->findOneBy(array(
                'invitedEmail' => $invitation->getEmail(),
                'referralHash' => $referralHash,
            ));
        if ($referralLine instanceof ReferralLine) {
            throw new ReferralProgramLineExistsException();
        }

        /** @var $customer Customer */
        $customer = $this
            ->customerRepository
            ->findOneByEmail($invitation->getEmail());

        if ($customer instanceof Customer) {
            throw new ReferralProgramEmailIsUserException();
        }
        /**
         * New referral line
         */
        $referralLine = $this->referralLineFactory->create();
        $referralLine
            ->setReferralHash($referralHash)
            ->setInvitedEmail($invitation->getEmail())
            ->setInvitedName($invitation->getName())
            ->setSource($invitation->getSource())
            ->setReferralRule($referralRule)
            ->setReferrerType($referralRule->getReferrerType())
            ->setReferrerCoupon($referralRule->getReferrerCoupon())
            ->setInvitedType($referralRule->getInvitedType())
            ->setInvitedCoupon($referralRule->getInvitedCoupon());

        /**
         * Persists and flushes new entity
         */
        $this->manager->persist($referralLine);
        $this->manager->flush($referralLine);

        $referralLink = $this->referralRouteManager->generateControllerRoute($referralHash);

        /**
         * Invitation done event is raised
         */
        $event = new ReferralProgramInvitationEvent($referralLine, $referralLink);
        $this->eventDispatcher->dispatch(ElcodiReferralProgramEvents::REFERRAL_PROGRAM_INVITATION, $event);

        return $this;
    }
}
