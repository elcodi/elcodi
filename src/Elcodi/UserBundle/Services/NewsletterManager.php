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

namespace Elcodi\UserBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ValidatorInterface;

use Elcodi\UserBundle\ElcodiUserEvents;
use Elcodi\UserBundle\Entity\Interfaces\CustomerInterface;
use Elcodi\UserBundle\Entity\NewsletterSubscription;
use Elcodi\UserBundle\Event\NewsletterSubscriptionEvent;
use Elcodi\UserBundle\Exception\NewsletterCannotBeAddedException;
use Elcodi\UserBundle\Exception\NewsletterCannotBeRemovedException;
use Elcodi\UserBundle\Wrapper\CustomerWrapper;

/**
 * Manager for newsletter
 */
class NewsletterManager
{

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @var ObjectManager
     *
     * Entity Manager
     */
    protected $entityManager;

    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher instance
     */
    protected $eventDispatcher;

    /**
     * @var ValidatorInterface
     *
     * Validator instance
     */
    protected $validator;

    /**
     * Construct method
     *
     * @param CustomerWrapper          $customerWrapper Customer wrapper
     * @param ObjectManager            $entityManager   Entity manager
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher
     * @param ValidatorInterface       $validator       Validator class
     */
    public function __construct(CustomerWrapper $customerWrapper, ObjectManager $entityManager, EventDispatcherInterface $eventDispatcher, ValidatorInterface $validator)
    {
        $this->customer = $customerWrapper->getCustomer();
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->validator = $validator;
    }

    /**
     * Return if email is valid
     *
     * @param string $email Email
     *
     * @return string Email
     */
    protected function validateEmail($email)
    {

        $validationViolationList = $this
            ->validator
            ->validateValue($email, new Email());

        return ($validationViolationList->count() == 0);
    }

    /**
     * Subscribe email to newsletter
     *
     * @param String   $email    Email
     * @param LanguageInterface $language The language
     *
     * @return $this
     *
     * @throws NewsletterCannotBeAddedException
     */
    public function subscribe($email, LanguageInterface $language)
    {
        if (!$this->validateEmail($email)) {

            throw new NewsletterCannotBeAddedException();
        }

        $newsletterExists = true;
        $newsletterSubscription = $this->getSubscription($email);

        if (!($newsletterSubscription instanceof NewsletterSubscription)) {

            $newsletterExists = false;
            $subscriptionHash = hash("sha1", uniqid(rand(), true));
            $newsletterSubscription = new NewsletterSubscription();
            $newsletterSubscription
                ->setEmail($email)
                ->setHash($subscriptionHash)
                ->setLanguage($language);
        }

        $newsletterSubscription->enable();

        if ($this->customer->getId() > 0) {
            $newsletterSubscription->setCustomer($this->customer);
        }

        //check that email matches
        $customer = $this->entityManager->getRepository('ElcodiUserBundle:Customer')->findOneByEmail($email);
        if ($customer instanceof CustomerInterface) {
            $newsletterSubscription->setCustomer($customer);
        }

        if (!$newsletterExists) {

            $this->entityManager->persist($newsletterSubscription);
        }

        $this->entityManager->flush();

        /**
         * Subscribe event triggered
         */
        $newsletterSubscriptionEvent = new NewsletterSubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(ElcodiUserEvents::NEWSLETTER_SUBSCRIBE, $newsletterSubscriptionEvent);

        return $this;
    }

    /**
     * Unsubscribe email from newsletter
     *
     * @param string $email  Email
     * @param string $hash   Hash to remove
     * @param string $reason reason if it exists
     *
     * @return $this
     *
     * @throws NewsletterCannotBeRemovedException
     */
    public function unSubscribe($email, $hash, $reason = "")
    {
        if (!$this->validateEmail($email)) {

            throw new NewsletterCannotBeRemovedException();
        }

        $newsletterSubscription = $this
            ->entityManager
            ->getRepository('ElcodiUserBundle:NewsletterSubscription')
            ->findOneBy(array(
                'email' =>  $email,
                'hash'  =>  $hash,
            ));

        if (!($newsletterSubscription instanceof NewsletterSubscription)) {

            throw new NewsletterCannotBeRemovedException();
        }

        $newsletterSubscription->disable();
        if ($reason) {
            $newsletterSubscription->setReason($reason);
        }
        $this->entityManager->flush();

        /**
         * Subscribe event triggered
         */
        $newsletterSubscriptionEvent = new NewsletterSubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(ElcodiUserEvents::NEWSLETTER_UNSUBSCRIBE, $newsletterSubscriptionEvent);

        return $this;
    }

    /**
     * Is subscribed
     *
     * @param string $email Email
     *
     * @return boolean Is subscribed
     */
    public function isSubscribed($email)
    {
        $newsletterSubscription = $this->getSubscription($email);

        return ($newsletterSubscription instanceof NewsletterSubscription);
    }

    /**
     * Is subscribed
     *
     * @param string $email Email
     *
     * @return boolean Is subscribed
     */
    public function getSubscription($email)
    {
        return $this
            ->entityManager
            ->getRepository('ElcodiUserBundle:NewsletterSubscription')
            ->findOneByEmail($email);
    }
}
