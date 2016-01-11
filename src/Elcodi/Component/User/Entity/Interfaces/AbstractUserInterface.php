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

namespace Elcodi\Component\User\Entity\Interfaces;

use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

use Elcodi\Component\Core\Entity\Interfaces\DateTimeInterface;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Core\Entity\Interfaces\IdentifiableInterface;

/**
 * Interface AbstractUserInterface.
 */
interface AbstractUserInterface
    extends
    IdentifiableInterface,
    UserInterface,
    LastLoginInterface,
    DateTimeInterface,
    EnabledInterface
{
    /**
     * Sets a hash so it can be used to login once without the need to use the password.
     *
     * @param string $oneTimeLoginHash The hash you want to set for the one time login
     *
     * @return $this Self object
     */
    public function setOneTimeLoginHash($oneTimeLoginHash);

    /**
     * Gets the one time login hash.
     *
     * @return string Login hash
     */
    public function getOneTimeLoginHash();

    /**
     * Set recovery hash.
     *
     * @param string $recoveryHash
     *
     * @return $this Self object
     */
    public function setRecoveryHash($recoveryHash);

    /**
     * Get recovery hash.
     *
     * @return string Recovery Hash
     */
    public function getRecoveryHash();

    /**
     * Sets Firstname.
     *
     * @param string $firstname Firstname
     *
     * @return $this Self object
     */
    public function setFirstname($firstname);

    /**
     * Get Firstname.
     *
     * @return string Firstname
     */
    public function getFirstname();

    /**
     * Sets Lastname.
     *
     * @param string $lastname Lastname
     *
     * @return $this Self object
     */
    public function setLastname($lastname);

    /**
     * Get Lastname.
     *
     * @return string Lastname
     */
    public function getLastname();

    /**
     * Set gender.
     *
     * @param int $gender Gender
     *
     * @return $this Self object
     */
    public function setGender($gender);

    /**
     * Get gender.
     *
     * @return int Gender
     */
    public function getGender();

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return $this Self object
     */
    public function setEmail($email);

    /**
     * Return email.
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Get birthday.
     *
     * @return DateTime
     */
    public function getBirthday();

    /**
     * Set birthday.
     *
     * @param DateTime $birthday
     *
     * @return $this Self object
     */
    public function setBirthday(DateTime $birthday = null);

    /**
     * Get user full name.
     *
     * @return string Full name
     */
    public function getFullName();

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return $this Self object
     */
    public function setPassword($password);

    /**
     * Get Token.
     *
     * @return string Token
     */
    public function getToken();

    /**
     * Sets Token.
     *
     * @param string $token Token
     *
     * @return $this Self object
     */
    public function setToken($token);
}
