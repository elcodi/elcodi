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

namespace Elcodi\Component\User\EventListener\Abstracts;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Password event listener.
 */
abstract class AbstractPasswordEventListener
{
    /**
     * @var PasswordEncoderInterface
     *
     * Password encoder
     */
    protected $passwordEncoder;

    /**
     * Construct method.
     *
     * @param PasswordEncoderInterface $passwordEncoder Password encoder
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * PreUpdate event listener.
     *
     * Only computes password change if password is one of file to be changed
     *
     * @param PreUpdateEventArgs $eventArgs Event args
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if ($this->checkEntityType($entity)) {
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
     * New entity. Password must be encrypted always.
     *
     * @param LifecycleEventArgs $args Event args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($this->checkEntityType($entity)) {
            $password = $entity->getPassword();

            if (!empty($password)) {
                $encodedPassword = $this->encryptPassword($password);
                $entity->setPassword($encodedPassword);
            }
        }
    }

    /**
     * Encode a password.
     *
     * @param string      $password Password
     * @param string|null $salt     salt
     *
     * @return string password encrypted
     */
    public function encryptPassword($password, $salt = null)
    {
        return $this->passwordEncoder->encodePassword($password, $salt);
    }

    /**
     * Check entity type.
     *
     * @param $entity Object Entity to check
     *
     * @return bool Entity is ready for being encoded
     */
    abstract public function checkEntityType($entity);
}
