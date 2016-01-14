<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2016 Elcodi Networks S.L.
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

namespace Elcodi\Component\Newsletter\Services;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\RecursiveValidator;

use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\Language\Entity\Interfaces\LanguageInterface;
use Elcodi\Component\Newsletter\Entity\Interfaces\NewsletterSubscriptionInterface;
use Elcodi\Component\Newsletter\EventDispatcher\NewsletterEventDispatcher;
use Elcodi\Component\Newsletter\Exception\NewsletterCannotBeAddedException;
use Elcodi\Component\Newsletter\Exception\NewsletterCannotBeRemovedException;
use Elcodi\Component\Newsletter\Factory\NewsletterSubscriptionFactory;
use Elcodi\Component\Newsletter\Repository\NewsletterSubscriptionRepository;

/**
 * Manager for newsletter.
 */
class NewsletterManager
{
    /**
     * @var NewsletterEventDispatcher
     *
     * Newsletter EventDispatcher
     */
    private $newsletterEventDispatcher;

    /**
     * @var RecursiveValidator
     *
     * Validator instance
     */
    private $validator;

    /**
     * @var NewsletterSubscriptionFactory
     *
     * Newsletter Subscription Factory
     */
    private $newsletterSubscriptionFactory;

    /**
     * @var NewsletterSubscriptionRepository
     *
     * NewsletterSubscription Repository
     */
    private $newsletterSubscriptionRepository;

    /**
     * @var GeneratorInterface
     *
     * Hash Generator
     */
    private $hashGenerator;

    /**
     * Construct method.
     *
     * @param NewsletterEventDispatcher        $newsletterEventDispatcher        Newsletter EventDispatcher
     * @param RecursiveValidator               $validator                        Validator class
     * @param NewsletterSubscriptionFactory    $newsletterSubscriptionFactory    NewsletterSubscription Factory
     * @param NewsletterSubscriptionRepository $newsletterSubscriptionRepository NewsletterSubscription Repository
     * @param GeneratorInterface               $hashGenerator                    Hash generator
     */
    public function __construct(
        NewsletterEventDispatcher $newsletterEventDispatcher,
        RecursiveValidator $validator,
        NewsletterSubscriptionFactory $newsletterSubscriptionFactory,
        NewsletterSubscriptionRepository $newsletterSubscriptionRepository,
        GeneratorInterface $hashGenerator
    ) {
        $this->newsletterEventDispatcher = $newsletterEventDispatcher;
        $this->validator = $validator;
        $this->newsletterSubscriptionFactory = $newsletterSubscriptionFactory;
        $this->newsletterSubscriptionRepository = $newsletterSubscriptionRepository;
        $this->hashGenerator = $hashGenerator;
    }

    /**
     * Subscribe email to newsletter.
     *
     * @param string            $email    Email
     * @param LanguageInterface $language The language
     *
     * @return $this Self object
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
     * Unsubscribe email from newsletter.
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

        $conditions = [
            'email' => $email,
            'hash' => $hash,
        ];

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
     * Is subscribed.
     *
     * @param string $email Email
     *
     * @return bool Is subscribed
     */
    public function isSubscribed($email)
    {
        $newsletterSubscription = $this->getSubscription($email);

        return $newsletterSubscription instanceof NewsletterSubscriptionInterface;
    }

    /**
     * Is subscribed.
     *
     * @param string $email Email
     *
     * @return object|null Subscription instance if exists
     */
    public function getSubscription($email)
    {
        return $this
            ->newsletterSubscriptionRepository
            ->findOneBy([
                'email' => $email,
            ]);
    }

    /**
     * Return if email is valid.
     *
     * @param string $email Email
     *
     * @return bool Email is valid
     */
    public function validateEmail($email)
    {
        if (empty($email)) {
            return false;
        }

        $validationViolationList = $this
            ->validator
            ->validate($email, new Email());

        return $validationViolationList->count() === 0;
    }
}
