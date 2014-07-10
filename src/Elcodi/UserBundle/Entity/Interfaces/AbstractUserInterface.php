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

namespace Elcodi\UserBundle\Entity\Interfaces;

use DateTime;

/**
 * Class AbstractUserInterface
 */
interface AbstractUserInterface
{
    /**
     * User roles
     *
     * @return array Roles
     */
    public function getRoles();

    /**
     * Set recovery hash
     *
     * @param string $recoveryHash
     *
     * @return AbstractUserInterface self Object
     */
    public function setRecoveryHash($recoveryHash);

    /**
     * Get recovery hash
     *
     * @return string Recovery Hash
     */
    public function getRecoveryHash();

    /**
     * Sets Firstname
     *
     * @param string $firstname Firstname
     *
     * @return AbstractUserInterface Self object
     */
    public function setFirstname($firstname);

    /**
     * Get Firstname
     *
     * @return string Firstname
     */
    public function getFirstname();

    /**
     * Sets Lastname
     *
     * @param string $lastname Lastname
     *
     * @return AbstractUserInterface Self object
     */
    public function setLastname($lastname);

    /**
     * Get Lastname
     *
     * @return string Lastname
     */
    public function getLastname();

    /**
     * Set gender
     *
     * @param int $gender Gender
     *
     * @return AbstractUserInterface self Object
     */
    public function setGender($gender);

    /**
     * Get gender
     *
     * @return int Gender
     */
    public function getGender();

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AbstractUserInterface self Object
     */
    public function setEmail($email);

    /**
     * Return email
     *
     * @return string Email
     */
    public function getEmail();

    /**
     * Set username
     *
     * @param string $username Username
     *
     * @return AbstractUserInterface self Object
     */
    public function setUsername($username);

    /**
     * Get username
     *
     * @return String Username
     */
    public function getUsername();

    /**
     * Get birthday
     *
     * @return DateTime
     */
    public function getBirthday();

    /**
     * Set birthday
     *
     * @param DateTime $birthday
     *
     * @return AbstractUserInterface self Object
     */
    public function setBirthday(DateTime $birthday = null);

    /**
     * Get user full name
     *
     * @return string Full name
     */
    public function getFullName();

    /**
     * Set password
     *
     * @param string $password
     *
     * @return AbstractUserInterface self Object
     */
    public function setPassword($password);

    /**
     * Get password
     *
     * @return string Password
     */
    public function getPassword();
}
