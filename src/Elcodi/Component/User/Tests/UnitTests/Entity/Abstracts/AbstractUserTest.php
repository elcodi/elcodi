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

namespace Elcodi\Component\User\Tests\UnitTests\Entity\Abstracts;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\User\Entity\Abstracts\AbstractUser;
use Elcodi\Component\User\Exception\InvalidPasswordException;

/**
 * Class AbstractUserTest.
 */
class AbstractUserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test user genders.
     *
     * @param int $gender
     * @param int $expected
     *
     * @dataProvider gendersProvider
     */
    public function testGender($gender, $expected)
    {
        $user = $this->getMockForAbstractClass('Elcodi\Component\User\Entity\Abstracts\AbstractUser');
        $setterOutput = $user->setGender($gender);

        $this->assertInstanceOf(
            'Elcodi\Component\User\Entity\Abstracts\AbstractUser',
            $setterOutput
        );

        $this->assertEquals($expected, $user->getGender());
    }

    /**
     * @return array
     */
    public function gendersProvider()
    {
        return [
            [AbstractUser::GENDER_UNDEFINED, 0],
            [AbstractUser::GENDER_MALE, 1],
            [AbstractUser::GENDER_FEMALE, 2],
            [mt_rand(3, PHP_INT_MAX), AbstractUser::GENDER_UNDEFINED],
            [
                mt_rand(~PHP_INT_MAX /* PHP_INT_MIN === ~PHP_INT_MAX */, -1),
                AbstractUser::GENDER_UNDEFINED,
            ],
        ];
    }

    /**
     * Test set password method.
     */
    public function testSetPassword()
    {
        $user = $this->getMockForAbstractClass('Elcodi\Component\User\Entity\Abstracts\AbstractUser');
        $user->setPassword('00000');
        $this->assertEquals(
            '00000',
            $user->getPassword()
        );

        $user->setPassword(null);
        $this->assertEquals(
            '00000',
            $user->getPassword()
        );
    }

    /**
     * Test set password method without exception.
     */
    public function testSetPasswordWithoutException()
    {
        $user = $this->getMockForAbstractClass('Elcodi\Component\User\Entity\Abstracts\AbstractUser');
        $user->setPassword('  1  ');
        $user->setPassword('1234');
        $user->setPassword('blabla');
    }

    /**
     * Test set password method with exception.
     *
     * @dataProvider dataSetPasswordWithException
     */
    public function testSetPasswordWithException($value)
    {
        $user = $this->getMockForAbstractClass('Elcodi\Component\User\Entity\Abstracts\AbstractUser');
        $user->setPassword('00000');
        try {
            $user->setPassword($value);
            $this->fail('AbstractUser::setPassword($password) should contain a null value or a string');
        } catch (InvalidPasswordException $e) {
            //Silent pass
        }
    }

    /**
     * Data for testSetPasswordWithException.
     */
    public function dataSetPasswordWithException($value)
    {
        return [
            [true],
            [false],
            [''],
            ['   '],
            [0],
        ];
    }
}
