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

namespace Elcodi\Component\Comment\Tests\Entity;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Core\Tests\Entity\Traits;

class VoteTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait;

    /**
     * @var Vote
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Vote();
    }

    public function testComment()
    {
        $comment = $this->getMock('Elcodi\Component\Comment\Entity\Interfaces\CommentInterface');

        $setterOutput = $this->object->setComment($comment);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getComment();
        $this->assertSame($comment, $getterOutput);
    }

    public function testType()
    {
        $type = (bool) rand(0, 1);

        $setterOutput = $this->object->setType($type);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getType();
        $this->assertSame($type, $getterOutput);
    }

    public function testAuthorToken()
    {
        $authorToken = sha1(rand());

        $setterOutput = $this->object->setAuthorToken($authorToken);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAuthorToken();
        $this->assertSame($authorToken, $getterOutput);
    }
}
