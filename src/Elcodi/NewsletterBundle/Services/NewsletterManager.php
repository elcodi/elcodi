<?php

/**
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
 */

namespace Elcodi\NewsletterBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ValidatorInterface;

use Elcodi\CoreBundle\Generator\Interfaces\GeneratorInterface;
use Elcodi\CoreBundle\Entity\Interfaces\LanguageInterface;
use Elcodi\NewsletterBundle\Repository\NewsletterSubscriptionRepository;
use Elcodi\NewsletterBundle\Factory\NewsletterSubscriptionFactory;
use Elcodi\NewsletterBundle\ElcodiNewsletterEvents;
use Elcodi\NewsletterBundle\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\NewsletterBundle\Event\NewsletterSubscriptionEvent;
use Elcodi\NewsletterBundle\Exception\NewsletterCannotBeAddedException;
use Elcodi\NewsletterBundle\Exception\NewsletterCannotBeRemovedException;

/**
 * Manager for newsletter
 */
class NewsletterManager
{
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
     * @var NewsletterSubscriptionFactory
     *
     * Newsletter Subscription Factory
     */
    protected $newsletterSubscriptionFactory;

    /**
     * @var NewsletterSubscriptionRepository
     *
     * NewsletterSubscription Repository
     */
    protected $newsletterSubscriptionRepository;

    /**
     * @var GeneratorInterface
     *
     * Hash Generator
     */
    protected $hashGenerator;

    /**
     * Construct method
     *
     * @param EventDispatcherInterface         $eventDispatcher                  Event dispatcher
     * @param ObjectManager                    $entityManager                    Entity manager
     * @param ValidatorInterface               $validator                        Validator class
     * @param NewsletterSubscriptionFactory    $newsletterSubscriptionFactory    NewsletterSubscription Factory
     * @param NewsletterSubscriptionRepository $newsletterSubscriptionRepository NewsletterSubscription Repository
     * @param GeneratorInterface               $hashGenerator                    Hash generator
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ObjectManager $entityManager,
        ValidatorInterface $validator,
        NewsletterSubscriptionFactory $newsletterSubscriptionFactory,
        NewsletterSubscriptionRepository $newsletterSubscriptionRepository,
        GeneratorInterface $hashGenerator
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->newsletterSubscriptionFactory = $newsletterSubscriptionFactory;
        $this->newsletterSubscriptionRepository = $newsletterSubscriptionRepository;
        $this->hashGenerator = $hashGenerator;
    }

    /**
     * Subscribe email to newsletter
     *
     * @param String            $email    Email
     * @param LanguageInterface $language The language
     *
     * @return NewsletterManager self Object
     *
     * @throws NewsletterCannotBeAddedException
     *
     * @api
     */
    public function subscribe($email, LanguageInterface $language = null)
    {
        if (!$this->validateEmail($email)) {

            throw new NewsletterCannotBeAddedException();
        }

        $newsletterSubscription = $this->getSubscription($email);

        if (!($newsletterSubscription instanceof NewsletterSubscriptionInterface)) {

            $newsletterSubscription = $this->newsletterSubscriptionFactory->create();
            $newsletterSubscription
                ->setEmail($email)
                ->setHash($this->hashGenerator->generate())
                ->setLanguage($language);
        }

        $newsletterSubscription->setEnabled(true);

        $this->entityManager->persist($newsletterSubscription);
        $this->entityManager->flush();

        /**
         * Subscribe event triggered
         */
        $newsletterSubscriptionEvent = new NewsletterSubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(ElcodiNewsletterEvents::NEWSLETTER_SUBSCRIBE, $newsletterSubscriptionEvent);

        return $this;
    }

    /**
     * Unsubscribe email from newsletter
     *
     * @param string            $email    Email
     * @param string            $hash     Hash to remove
     * @param LanguageInterface $language Language
     * @param string            $reason   reason if it exists
     *
     * @return $this
     *
     * @throws NewsletterCannotBeRemovedException
     *
     * @api
     */
    public function unSubscribe($email, $hash, LanguageInterface $language = null, $reason = null)
    {
        if (!$this->validateEmail($email)) {

            throw new NewsletterCannotBeRemovedException();
        }

        $conditions = array(
            'email' => $email,
            'hash'  => $hash,
        );

        if ($language instanceof LanguageInterface) {

            $conditions['language'] = $language;
        }

        $newsletterSubscription = $this
            ->newsletterSubscriptionRepository
            ->findOneBy($conditions);

        if (!($newsletterSubscription instanceof NewsletterSubscriptionInterface)) {

            throw new NewsletterCannotBeRemovedException();
        }

        $newsletterSubscription
            ->setEnabled(false)
            ->setReason($reason);

        $this->entityManager->flush();

        /**
         * Subscribe event triggered
         */
        $newsletterSubscriptionEvent = new NewsletterSubscriptionEvent($newsletterSubscription);
        $this->eventDispatcher->dispatch(ElcodiNewsletterEvents::NEWSLETTER_UNSUBSCRIBE, $newsletterSubscriptionEvent);

        return $this;
    }

    /**
     * Is subscribed
     *
     * @param string $email Email
     *
     * @return boolean Is subscribed
     *
     * @api
     */
    public function isSubscribed($email)
    {
        $newsletterSubscription = $this->getSubscription($email);

        return ($newsletterSubscription instanceof NewsletterSubscriptionInterface);
    }

    /**
     * Is subscribed
     *
     * @param string $email Email
     *
     * @return boolean Is subscribed
     *
     * @api
     */
    public function getSubscription($email)
    {
        return $this
            ->newsletterSubscriptionRepository
            ->findOneBy(array(
                'email' => $email
            ));
    }

    /**
     * Return if email is valid
     *
     * @param string $email Email
     *
     * @return string Email
     *
     * @api
     */
    public function validateEmail($email)
    {
        if (empty($email)) {
            return false;
        }

        $validationViolationList = $this
            ->validator
            ->validateValue($email, new Email());

        return ($validationViolationList->count() == 0);
    }
}
