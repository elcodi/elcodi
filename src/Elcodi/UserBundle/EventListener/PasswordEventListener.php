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

namespace Elcodi\UserBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

use Elcodi\UserBundle\Entity\Abstracts\AbstractUser;

/**
 * Password event listener
 */
class PasswordEventListener
{
    /**
     * @var PasswordEncoderInterface
     *
     * Password encoder
     */
    protected $passwordEncoder;

    /**
     * Construct method
     *
     * @param PasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * PreUpdate event listener
     *
     * Only computes password change if password is one of file to be changed
     *
     * @param PreUpdateEventArgs $eventArgs Event args
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($entity instanceof AbstractUser) {

            if ($eventArgs->hasChangedField('password')) {

                $password = $entity->getPassword();
                if (!empty($password)) {

                    $encodedPassword = $this->encryptPassword($password);
                    $eventArgs->setNewValue('password', $encodedPassword);
                }

            }
        }

    }

    /**
     * New entity. Password must be encrypted always
     *
     * @param LifecycleEventArgs $args Event args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof AbstractUser) {

            $password = $entity->getPassword();

            if (!empty($password)) {

                $encodedPassword = $this->encryptPassword($password);
                $entity->setPassword($encodedPassword);
            }
        }

    }

    /**
     * Encode a password
     *
     * @param string $password Password
     * @param string $salt     salt
     *
     * @return string password encrypted
     */
    public function encryptPassword($password, $salt = null)
    {
        return $this->passwordEncoder->encodePassword($password, $salt);
    }
}
