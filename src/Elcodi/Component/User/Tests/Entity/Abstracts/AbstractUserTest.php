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

namespace Elcodi\Component\User\Tests\Entity\Abstracts;

use DateTime;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\User\Entity\Abstracts\AbstractUser;

class AbstractUserTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var AbstractUser
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = $this
            ->getMockBuilder('Elcodi\Component\User\Entity\Abstracts\AbstractUser')
            ->getMockForAbstractClass();
    }

    public function testGetRoles()
    {
        $roles = $this->object->getRoles();

        $this->assertInternalType('array', $roles);
        $this->assertContainsOnlyInstancesOf(
            'Symfony\Component\Security\Core\Role\Role',
            $roles
        );
    }

    public function testFirstname()
    {
        $firstname = sha1(rand());

        $setterOutput = $this->object->setFirstname($firstname);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getFirstname();
        $this->assertSame($firstname, $getterOutput);
    }

    public function testLastname()
    {
        $lastname = sha1(rand());

        $setterOutput = $this->object->setLastname($lastname);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLastname();
        $this->assertSame($lastname, $getterOutput);
    }

    public function testGender()
    {
        $gender = rand();

        $setterOutput = $this->object->setGender($gender);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getGender();
        $this->assertSame($gender, $getterOutput);
    }

    public function testEmail()
    {
        $email = sha1(rand()) . '@example.com';

        $setterOutput = $this->object->setEmail($email);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEmail();
        $this->assertSame($email, $getterOutput);
    }

    public function testToken()
    {
        $token = sha1(rand());

        $setterOutput = $this->object->setToken($token);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getToken();
        $this->assertSame($token, $getterOutput);
    }

    public function testGetUsername()
    {
        $email = sha1(rand()) . '@example.com';

        $setterOutput = $this->object->setEmail($email);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getUsername();
        $this->assertSame($email, $getterOutput);
    }

    public function testBirthday()
    {
        $birthday = new DateTime();

        $setterOutput = $this->object->setBirthday($birthday);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getBirthday();
        $this->assertSame($birthday, $getterOutput);
    }

    public function testRecoveryHash()
    {
        $recoveryHash = sha1(rand());

        $setterOutput = $this->object->setRecoveryHash($recoveryHash);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getRecoveryHash();
        $this->assertSame($recoveryHash, $getterOutput);
    }

    public function testGetFullName()
    {
        $firstname = sha1(rand());
        $lastname = sha1(rand());

        $this->object->setFirstname($firstname);
        $this->object->setLastname($lastname);

        $fullName = $this->object->getFullName();

        $this->assertSame(
            sprintf('%s %s', $firstname, $lastname),
            $fullName
        );
    }

    public function testPassword()
    {
        $password = sha1(rand());

        $setterOutput = $this->object->setPassword($password);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getPassword();
        $this->assertSame($password, $getterOutput);

        // password can't be empty
        $this->object->setPassword(null);
        $this->assertSame($password, $this->object->getPassword());

        $this->object->setPassword('');
        $this->assertSame($password, $this->object->getPassword());
    }

    public function testOneTimeLoginHash()
    {
        $oneTimeLoginHash = sha1(rand());

        $setterOutput = $this->object->setOneTimeLoginHash($oneTimeLoginHash);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getOneTimeLoginHash();
        $this->assertSame($oneTimeLoginHash, $getterOutput);
    }

    public function testGetSalt()
    {
        $this->assertInternalType(
            'string',
            $this->object->getSalt()
        );
    }

    public function testEraseCredentials()
    {
        $this->assertInternalType(
            'string',
            $this->object->eraseCredentials()
        );
    }

    public function testToString()
    {
        $firstname = sha1(rand());
        $lastname = sha1(rand());

        $this->object->setFirstname($firstname);
        $this->object->setLastname($lastname);

        $this->assertSame(
            sprintf('%s %s', $firstname, $lastname),
            (string) $this->object
        );
    }

    public function testSleep()
    {
        $attributes = $this->object->__sleep();

        $this->assertInternalType('array', $attributes);

        $class = get_class($this->object);
        foreach ($attributes as $attribute) {
            $this->assertClassHasAttribute($attribute, $class);
        }
    }
}
