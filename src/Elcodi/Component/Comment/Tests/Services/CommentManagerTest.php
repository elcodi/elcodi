<?php

/**
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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
            $this->commentObjectManager,
            $this->commentRepository,
            $this->commentFactory,
            $commentParser,
            'key'
        );

        $this
            ->commentManager
            ->setCache($this->getMockForAbstractClass('Doctrine\Common\Cache\CacheProvider'))
            ->setEncoder($this->getMock('Elcodi\Component\Core\Encoder\Interfaces\EncoderInterface'));
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

    /**
     * Test load
     */
    public function testLoad()
    {
        $this
            ->commentRepository
            ->expects($this->any())
            ->method('getAllCommentsSortedByParentAndIdAsc')
            ->with($this->equalTo('source'))
            ->will($this->returnValue($this->getCommentsStructure()));

        $comments = $this
            ->commentManager
            ->load('source');

        $this->assertEquals([
            [
                'entity'   => [
                    'id'             => 1,
                    'authorFullName' => null,
                    'authorUsername' => null,
                    'authorEmail'    => null,
                    'content'        => 'comment1',
                    'parsedContent'  => 'comment1',
                    'parsedType'     => 'none',
                ],
                'children' => [
                    [
                        'entity'   => [
                            'id'             => 2,
                            'authorFullName' => null,
                            'authorUsername' => null,
                            'authorEmail'    => null,
                            'parsedContent'  => 'comment2',
                            'content'        => 'comment2',
                            'parsedType'     => 'none',
                        ],
                        'children' => [],
                    ],
                    [
                        'entity'   => [
                            'id'             => 3,
                            'authorFullName' => null,
                            'authorUsername' => null,
                            'authorEmail'    => null,
                            'parsedContent'  => 'comment3',
                            'content'        => 'comment3',
                            'parsedType'     => 'none',
                        ],
                        'children' => [],
                    ]
                ],
            ],
            [
                'entity'   => [
                    'id'             => 4,
                    'authorFullName' => null,
                    'authorUsername' => null,
                    'authorEmail'    => null,
                    'content'        => 'comment4',
                    'parsedContent'  => 'comment4',
                    'parsedType'     => 'none',
                ],
                'children' => [
                    [
                        'entity'   => [
                            'id'             => 5,
                            'authorFullName' => null,
                            'authorUsername' => null,
                            'authorEmail'    => null,
                            'content'        => 'comment5',
                            'parsedContent'  => 'comment5',
                            'parsedType'     => 'none',
                        ],
                        'children' => [],
                    ]
                ],
            ]
        ], $comments);
    }

    /**
     * Get comments structure
     *
     * @return Collection Comment Structure
     */
    protected function getCommentsStructure()
    {
        $comment1 = new Comment();
        $comment1
            ->setId(1)
            ->setSource('source')
            ->setParent(null)
            ->setAuthor($this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'))
            ->setContent('comment1')
            ->setParsedContent('comment1')
            ->setParsingType('none');

        $comment2 = new Comment();
        $comment2
            ->setId(2)
            ->setSource('source')
            ->setParent($comment1)
            ->setAuthor($this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'))
            ->setContent('comment2')
            ->setParsedContent('comment2')
            ->setParsingType('none');

        $comment3 = new Comment();
        $comment3
            ->setId(3)
            ->setSource('source')
            ->setParent($comment1)
            ->setAuthor($this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'))
            ->setContent('comment3')
            ->setParsedContent('comment3')
            ->setParsingType('none');

        $comment4 = new Comment();
        $comment4
            ->setId(4)
            ->setSource('source')
            ->setParent(null)
            ->setAuthor($this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'))
            ->setContent('comment4')
            ->setParsedContent('comment4')
            ->setParsingType('none');

        $comment5 = new Comment();
        $comment5
            ->setId(5)
            ->setSource('source')
            ->setParent($comment4)
            ->setAuthor($this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface'))
            ->setContent('comment5')
            ->setParsedContent('comment5')
            ->setParsingType('none');

        return new ArrayCollection([
            $comment1,
            $comment2,
            $comment3,
            $comment4,
            $comment5,
        ]);
    }
}
