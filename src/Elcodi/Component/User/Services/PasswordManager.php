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

namespace Elcodi\Component\User\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Elcodi\Component\Core\Generator\Interfaces\GeneratorInterface;
use Elcodi\Component\User\ElcodiUserEvents;
use Elcodi\Component\User\Entity\Abstracts\AbstractUser;
use Elcodi\Component\User\Event\PasswordRecoverEvent;
use Elcodi\Component\User\Event\PasswordRememberEvent;
use Elcodi\Component\User\Repository\Interfaces\UserEmaileableInterface;

/**
 * Manager for passwords
 */
class PasswordManager
{
    /**
     * @var ObjectManager
     *
     * Entity manager
     */
    protected $manager;

    /**
     * @var UrlGeneratorInterface
     *
     * Router generator
     */
    protected $router;

    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var GeneratorInterface
     *
     * Recovery hash generator
     */
    protected $recoveryHashGenerator;

    /**
     * @param ObjectManager            $manager               Manager
     * @param UrlGeneratorInterface    $router                Router
     * @param EventDispatcherInterface $eventDispatcher       Event Dispatcher
     * @param GeneratorInterface       $recoveryHashGenerator Recovery hash generator
     */
    public function __construct(
        ObjectManager $manager,
        UrlGeneratorInterface $router,
        EventDispatcherInterface $eventDispatcher,
        GeneratorInterface $recoveryHashGenerator
    ) {
        $this->manager = $manager;
        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
        $this->recoveryHashGenerator = $recoveryHashGenerator;
    }

    /**
     * Remember a password from a user, given its email
     *
     * @param UserEmaileableInterface $userRepository         User repository
     * @param string                  $email                  User email
     * @param string                  $recoverPasswordUrlName Recover password name
     * @param string                  $hashField              Hash
     *
     * @return boolean its been found and processed
     */
    public function rememberPasswordByEmail(
        UserEmaileableInterface $userRepository,
        $email,
        $recoverPasswordUrlName,
        $hashField = 'hash'
    ) {
        $user = $userRepository->findOneByEmail($email);

        if (!($user instanceof AbstractUser)) {
            return false;
        }

        $this->rememberPassword($user, $recoverPasswordUrlName, $hashField);

        return true;
    }

    /**
     * Set a user in a remember password mode. Also rises an event
     * to hook when this happens.
     *
     * Recover url must contain these fields with these names
     *
     * @param AbstractUser $user                   User
     * @param string       $recoverPasswordUrlName Recover password name
     * @param string       $hashField              Hash
     *
     * @return $this Self object
     */
    public function rememberPassword(
        AbstractUser $user,
        $recoverPasswordUrlName,
        $hashField = 'hash'
    ) {
        $recoveryHash = $this->recoveryHashGenerator->generate();
        $user->setRecoveryHash($recoveryHash);
        $this->manager->flush($user);

        $recoverUrl = $this
            ->router
            ->generate($recoverPasswordUrlName, array(
                $hashField => $recoveryHash,
            ), true);

        $event = new PasswordRememberEvent($user, $recoverUrl);
        $this->eventDispatcher->dispatch(ElcodiUserEvents::PASSWORD_REMEMBER, $event);

        return $this;
    }

    /**
     * Recovers a password given a user
     *
     * @param AbstractUser $user        User
     * @param string       $hash        Hash given by provider
     * @param string       $newPassword New password
     *
     * @return $this
     */
    public function recoverPassword(AbstractUser $user, $hash, $newPassword)
    {
        if ($hash == $user->getRecoveryHash()) {
            $user
                ->setPassword($newPassword)
                ->setRecoveryHash(null);
            $this->manager->flush($user);

            $event = new PasswordRecoverEvent($user);
            $this->eventDispatcher->dispatch(ElcodiUserEvents::PASSWORD_RECOVER, $event);
        }

        return $this;
    }
}
