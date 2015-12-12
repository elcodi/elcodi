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

namespace Elcodi\Component\Metric\Tests\Core\Entity;

use DateTime;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Metric\Core\Entity\Entry;

class EntryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Entry
     */
    protected $object;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $value;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->token = sha1(rand());
        $this->event = sha1(rand());
        $this->value = sha1(rand());
        $this->type = sha1(rand());
        $this->createdAt = new DateTime();

        $this->object = new Entry(
            $this->token,
            $this->event,
            $this->value,
            $this->type,
            $this->createdAt
        );
    }

    public function testGetId()
    {
        $this->assertNull($this->object->getId());
    }

    public function testGetToken()
    {
        $this->assertSame($this->token, $this->object->getToken());
    }

    public function testGetEvent()
    {
        $this->assertSame($this->event, $this->object->getEvent());
    }

    public function testGetValue()
    {
        $this->assertSame($this->value, $this->object->getValue());
    }

    public function testGetType()
    {
        $this->assertSame($this->type, $this->object->getType());
    }

    public function testGetCreatedAt()
    {
        $this->assertSame($this->createdAt, $this->object->getCreatedAt());
    }
}
