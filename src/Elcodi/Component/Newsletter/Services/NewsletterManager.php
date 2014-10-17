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
 */

namespace Elcodi\Component\Newsletter\Services;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\ValidatorInterface;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\Component\Newsletter\EventDispatcher\NewsletterEventDispatcher;
use Elcodi\Component\Newsletter\Exception\NewsletterCannotBeAddedException;
use Elcodi\Component\Newsletter\Exception\NewsletterCannotBeRemovedException;
use Elcodi\Component\Newsletter\Factory\NewsletterSubscriptionFactory;
use Elcodi\Component\Newsletter\Repository\NewsletterSubscriptionRepository;

/**
 * Manager for newsletter
 */
class NewsletterManager
{
    /**
     * @var NewsletterEventDispatcher
     *
     * Newsletter EventDispatcher
     */
    protected $newsletterEventDispatcher;

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
     * @param NewsletterEventDispatcher        $newsletterEventDispatcher        Newsletter EventDispatcher
     * @param ValidatorInterface               $validator                        Validator class
     * @param NewsletterSubscriptionFactory    $newsletterSubscriptionFactory    NewsletterSubscription Factory
     * @param NewsletterSubscriptionRepository $newsletterSubscriptionRepository NewsletterSubscription Repository
     * @param GeneratorInterface               $hashGenerator                    Hash generator
     */
    public function __construct(
        NewsletterEventDispatcher $newsletterEventDispatcher,
        ValidatorInterface $validator,
        NewsletterSubscriptionFactory $newsletterSubscriptionFactory,
        NewsletterSubscriptionRepository $newsletterSubscriptionRepository,
        GeneratorInterface $hashGenerator
    )
    {
        $this->newsletterEventDispatcher = $newsletterEventDispatcher;
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
     * @return $this self Object
     *
     * @throws NewsletterCannotBeAddedException
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

        $this
            ->newsletterEventDispatcher
            ->dispatchSubscribeEvent($newsletterSubscription);

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

        $this
            ->newsletterEventDispatcher
            ->dispatchUnsubscribeEvent($newsletterSubscription);

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

        return ($newsletterSubscription instanceof NewsletterSubscriptionInterface);
    }

    /**
     * Is subscribed
     *
     * @param string $email Email
     *
     * @return null|object Subscription instance if exists
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
     * @return boolean Email is valid
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
