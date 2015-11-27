<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi Networks S.L.
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

namespace Elcodi\Component\User\Entity\Abstracts;

use DateTime;
use Symfony\Component\Security\Core\Role\Role;

use Elcodi\Component\Core\Entity\Traits\DateTimeTrait;
use Elcodi\Component\Core\Entity\Traits\EnabledTrait;
use Elcodi\Component\Core\Entity\Traits\IdentifiableTrait;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;
use Elcodi\Component\User\Entity\Traits\LastLoginTrait;

/**
 * AbstractUser is the building block for simple User entities,
 * consisting of username, password, email
 */
abstract class AbstractUser implements AbstractUserInterface
{
    use IdentifiableTrait,
        LastLoginTrait,
        DateTimeTrait,
        EnabledTrait;

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
     * Token
     */
    protected $token;

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
     * @var integer
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
        return [
            new Role('IS_AUTHENTICATED_ANONYMOUSLY'),
        ];
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
     * @param integer $gender Gender
     *
     * @return $this Self object
     */
    public function setGender($gender)
    {
        $this->gender = (int) $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer Gender
     */
    public function getGender()
    {
        return (int) $this->gender;
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
     * Get Token
     *
     * @return string Token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets Token
     *
     * @param string $token Token
     *
     * @return $this Self object
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get username
     *
     * Just for symfony security purposes
     *
     * @return String Username
     */
    public function getUsername()
    {
        return $this->email;
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

    /**
     * Sleep implementation for some reason
     *
     * @link http://asiermarques.com/2013/symfony2-security-usernamepasswordtokenserialize-must-return-a-string-or-null/
     */
    public function __sleep()
    {
        return ['id', 'email'];
    }
}
