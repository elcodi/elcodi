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

namespace Elcodi\Component\Newsletter\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Core\Tests\Entity\Traits;
use Elcodi\Component\Newsletter\Entity\NewsletterSubscription;

class NewsletterSubscriptionTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait,
        Traits\DateTimeTrait,
        Traits\EnabledTrait;

    /**
     * @var NewsletterSubscription
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new NewsletterSubscription();
    }

    public function testEmail()
    {
        $email = sha1(rand()) . '@example.com';

        $setterOutput = $this->object->setEmail($email);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getEmail();
        $this->assertSame($email, $getterOutput);
    }

    public function testLanguage()
    {
        $language = $this->getMock('Elcodi\Component\Language\Entity\Interfaces\LanguageInterface');

        $setterOutput = $this->object->setLanguage($language);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getLanguage();
        $this->assertSame($language, $getterOutput);
    }

    public function testHash()
    {
        $hash = sha1(rand());

        $setterOutput = $this->object->setHash($hash);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getHash();
        $this->assertSame($hash, $getterOutput);
    }

    public function testReason()
    {
        $reason = sha1(rand());

        $setterOutput = $this->object->setReason($reason);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getReason();
        $this->assertSame($reason, $getterOutput);
    }

    public function testToString()
    {
        $email = sha1(rand()) . '@example.com';

        $setterOutput = $this->object->setEmail($email);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $this->assertSame($email, (string) $this->object);
    }
}
