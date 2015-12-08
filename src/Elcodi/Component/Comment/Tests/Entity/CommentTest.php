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

use Elcodi\Component\Comment\Entity\Comment;
use Elcodi\Component\Core\Tests\Entity\Traits;

class CommentTest extends PHPUnit_Framework_TestCase
{
    use Traits\IdentifiableTrait, Traits\DateTimeTrait, Traits\EnabledTrait;

    /**
     * @var Comment
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Comment();
    }

    public function testContent()
    {
        $content = sha1(rand());

        $setterOutput = $this->object->setContent($content);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getContent();
        $this->assertSame($content, $getterOutput);
    }

    public function testParent()
    {
        $parent = $this->getMock(get_class($this->object));

        $setterOutput = $this->object->setParent($parent);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getParent();
        $this->assertSame($parent, $getterOutput);
    }

    public function testSource()
    {
        $source = sha1(rand());

        $setterOutput = $this->object->setSource($source);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getSource();
        $this->assertSame($source, $getterOutput);
    }

    public function testChildren()
    {
        $children = $this->getMock('Doctrine\Common\Collections\Collection');

        $setterOutput = $this->object->setChildren($children);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getChildren();
        $this->assertSame($children, $getterOutput);
    }

    public function testContext()
    {
        $context = sha1(rand());

        $setterOutput = $this->object->setContext($context);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getContext();
        $this->assertSame($context, $getterOutput);
    }

    public function testAuthorEmail()
    {
        $authorEmail = sha1(rand());

        $setterOutput = $this->object->setAuthorEmail($authorEmail);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAuthorEmail();
        $this->assertSame($authorEmail, $getterOutput);
    }

    public function testAuthorName()
    {
        $authorName = sha1(rand());

        $setterOutput = $this->object->setAuthorName($authorName);
        $this->assertInstanceOf(get_class($this->object), $setterOutput);

        $getterOutput = $this->object->getAuthorName();
        $this->assertSame($authorName, $getterOutput);
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
