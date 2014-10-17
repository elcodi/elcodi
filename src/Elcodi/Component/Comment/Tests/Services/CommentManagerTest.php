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

namespace Elcodi\Component\Comment\Tests\Services;

use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Comment;
use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Factory\CommentFactory;
use Elcodi\Component\Comment\Repository\CommentRepository;
use Elcodi\Component\Comment\Services\CommentManager;
use Elcodi\Component\Comment\Services\CommentParser;

/**
 * Class CommentManagerTest
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
     * @var ObjectManager
     *
     * Comment Object Manager
     */
    protected $commentObjectManager;

    /**
     * @var CommentRepository
     *
     * Comment repository
     */
    protected $commentRepository;

    /**
     * @var CommentFactory
     *
     * Comment factory
     */
    protected $commentFactory;

    /**
     * Setup
     */
    public function setUp()
    {
        $this->commentObjectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->commentRepository = $this->getMock('Elcodi\Component\Comment\Repository\CommentRepository', [], [], '', false);
        $this->commentFactory = $this->getMock('Elcodi\Component\Comment\Factory\CommentFactory', [], [], '', false);

        $this
            ->commentFactory
            ->expects($this->any())
            ->method('create')
            ->will($this->returnValue(new Comment()));

        $parserAdapter = $this->getMock('Elcodi\Component\Comment\Adapter\Parser\Interfaces\ParserAdapterInterface');

        $parserAdapter
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnArgument(0));

        $parserAdapter
            ->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue('none'));

        $commentParser = new CommentParser($parserAdapter);

        $this->commentManager = new CommentManager(
            $this->getMock('Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher', [], [], '', false),
            $this->commentObjectManager,
            $this->commentRepository,
            $this->commentFactory,
            $commentParser
        );
    }

    /**
     * Test loading simple comments from source
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
                'This is my content',
                $this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'),
                null
            );

        $this->assertEquals('source', $comment->getSource());
        $this->assertGreaterThan(0, $comment->getId());
        $this->assertEquals('This is my content', $comment->getContent());
        $this->assertEquals('This is my content', $comment->getParsedContent());
        $this->assertEquals('none', $comment->getParsingType());
    }
}
