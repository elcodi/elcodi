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

namespace Elcodi\Component\Comment\Tests\Services;

use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Comment;
use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Services\CommentManager;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class CommentManagerTest.
 */
class CommentManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommentManager
     *
     * commentManager
     */
    protected $commentManager;

    /**
     * @var ObjectDirector
     *
     * Object director
     */
    protected $commentObjectDirector;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->commentObjectDirector = $this->getMock('Elcodi\Component\Core\Services\ObjectDirector', [], [], '', false);

        $this
            ->commentObjectDirector
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue(new Comment()));

        $this->commentManager = new CommentManager(
            $this->getMock('Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher', [], [], '', false),
            $this->commentObjectDirector
        );
    }

    /**
     * Test loading simple comments from source.
     */
    public function testAddComment()
    {
        /**
         * @var CommentInterface $comment
         */
        $comment = $this
            ->commentManager
            ->addComment(
                'source',
                'context',
                'This is my content',
                '12345',
                'Marc Morera',
                'engonga@engonga.com',
                null
            );

        $this->assertEquals('source', $comment->getSource());
        $this->assertGreaterThan(0, $comment->getId());
        $this->assertEquals('This is my content', $comment->getContent());
    }
}
