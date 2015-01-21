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

namespace Elcodi\Component\User\Entity\Abstracts;

use DateTime;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * AbstractUser is the building block for simple User entities,
 * consisting of username, password, email
 */
abstract class AbstractUser implements AbstractUserInterface
{
    use
        IdentifiableTrait,
        DateTimeTrait,
        EnabledTrait;

    /**
     * @var string
     *
     * Username
     */
    protected $username;

    /**
     * @var string
     *
     * Password
     */
    protected $password;

    /**
     * @var string
     *
     * Email
     */
    protected $email;

    /**
     * @var string
     *
     * Firstname
     */
    protected $firstname;

    /**
     * @var string
     *
     * Lastname
     */
    protected $lastname;

    /**
     * @var int
     *
     * gender
     */
    protected $gender;

    /**
     * @var DateTime
     *
     * Birthday
     */
    protected $birthday;

    /**
     * @var string
     *
     * Recovery hash
     */
    protected $recoveryHash;

    /**
     * @var string
     *
     * One time login hash.
     */
    protected $oneTimeLoginHash;

    /**
     * User roles
     *
     * @return string[] Roles
     */
    public function getRoles()
    {
        return array('IS_AUTHENTICATED_ANONYMOUSLY');
    }

    /**
     * Sets Firstname
     *
     * @param string $firstname Firstname
     *
     * @return $this Self object
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get Firstname
     *
     * @return string Firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Sets Lastname
     *
     * @param string $lastname Lastname
     *
     * @return $this Self object
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get Lastname
     *
     * @return string Lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set gender
     *
     * @param int $gender Gender
     *
     * @return $this Self object
     */
    public function setGender($gender)
    {
        $this->gender = (int)$gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return int Gender
     */
    public function getGender()
    {
        return (int)$this->gender;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return $this Self object
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Return email
     *
     * @return string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username Username
     *
     * @return $this Self object
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return String Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get birthday
     *
     * @return DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set birthday
     *
     * @param DateTime $birthday
     *
     * @return $this Self object
     */
    public function setBirthday(DateTime $birthday = null)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Set recovery hash
     *
     * @param string $recoveryHash
     *
     * @return $this Self object
     */
    public function setRecoveryHash($recoveryHash)
    {
        $this->recoveryHash = $recoveryHash;

        return $this;
    }

    /**
     * Get recovery hash
     *
     * @return string Recovery Hash
     */
    public function getRecoveryHash()
    {
        return $this->recoveryHash;
    }

    /**
     * Get user full name
     *
     * @return string Full name
     */
    public function getFullName()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    /**
     * Set password
     *
     * @param string $password Password
     *
     * @return $this Self object
     */
    public function setPassword($password)
    {
        if (null !== $password) {

            $this->password = $password;
        }

        return $this;
    }

    /**
     * Get password
     *
     * @return string Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Gets the one time login hash
     *
     * @return string Login hash
     */
    public function getOneTimeLoginHash()
    {
        return $this->oneTimeLoginHash;
    }

    /**
     * Sets a hash so it can be used to login once without the need to use the password
     *
     * @param string $oneTimeLoginHash The hash you want to set for the one time login
     *
     * @return $this Self object
     */
    public function setOneTimeLoginHash($oneTimeLoginHash)
    {
        $this->oneTimeLoginHash = $oneTimeLoginHash;

        return $this;
    }

    /**
     * Part of UserInterface. Dummy
     *
     * @return string Salt
     */
    public function getSalt()
    {
        return "";
    }

    /**
     * Dummy function, returns empty string
     *
     * @return string
     */
    public function eraseCredentials()
    {
        return "";
    }

    /**
     * String representation of the Customer
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getFullName();
    }
}
