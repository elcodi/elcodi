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

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Comment\Services\VoteManager;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class VoteManagerTest.
 */
class VoteManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommentEventDispatcher
     *
     * Comment event dispatcher
     */
    protected $commentEventDispatcher;

    /**
     * @var ObjectDirector
     *
     * Comment vote director
     */
    protected $voteDirector;

    /**
     * @var string
     *
     * Author token
     */
    protected $authorToken;

    /**
     * @var CommentInterface
     *
     * Comment
     */
    protected $comment;

    /**
     * @var VoteManager
     *
     * Vote manager
     */
    protected $voteManager;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->commentEventDispatcher = $this->getMock('Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher', [], [], '', false);
        $this->voteDirector = $this->getMock('Elcodi\Component\Core\Services\ObjectDirector', [], [], '', false);
        $this->authorToken = '12345';
        $this->comment = $this->getMock('Elcodi\Component\Comment\Entity\Interfaces\CommentInterface');

        $this->voteManager = new VoteManager(
            $this->commentEventDispatcher,
            $this->voteDirector
        );
    }

    /**
     * Test vote when no exists.
     */
    public function testVote()
    {
        $vote = new Vote();
        $this
            ->voteDirector
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this
            ->voteDirector
            ->expects($this->once())
            ->method('create')
            ->will($this->returnValue($vote));

        $this
            ->commentEventDispatcher
            ->expects($this->once())
            ->method('dispatchCommentOnVotedEvent')
            ->with(
                $this->equalTo($this->comment),
                $this->equalTo($vote),
                $this->equalTo(false)
            );

        $vote = $this
            ->voteManager
            ->vote(
                $this->comment,
                $this->authorToken,
                Vote::DOWN
            );

        $this->assertSame($this->authorToken, $vote->getAuthorToken());
        $this->assertSame($this->comment, $vote->getComment());
        $this->assertSame(Vote::DOWN, $vote->getType());
    }

    /**
     * Test vote when exists.
     */
    public function testExistingVote()
    {
        $vote = new Vote();
        $vote
            ->setAuthorToken($this->authorToken)
            ->setComment($this->comment)
            ->setType(Vote::UP);

        $this
            ->voteDirector
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($vote));

        $this
            ->voteDirector
            ->expects($this->never())
            ->method('create');

        $this
            ->commentEventDispatcher
            ->expects($this->once())
            ->method('dispatchCommentOnVotedEvent')
            ->with(
                $this->equalTo($this->comment),
                $this->equalTo($vote),
                $this->equalTo(true)
            );

        $vote = $this
            ->voteManager
            ->vote(
                $this->comment,
                $this->authorToken,
                Vote::DOWN
            );

        $this->assertSame($this->authorToken, $vote->getAuthorToken());
        $this->assertSame($this->comment, $vote->getComment());
        $this->assertSame(Vote::DOWN, $vote->getType());
    }

    /**
     * Test remove vote when exists.
     */
    public function testRemoveExistingVote()
    {
        $vote = new Vote();
        $vote
            ->setAuthorToken($this->authorToken)
            ->setComment($this->comment)
            ->setType(Vote::UP);

        $this
            ->voteDirector
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($vote));

        $this
            ->voteDirector
            ->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($vote));

        $this
            ->voteManager
            ->removeVote(
                $this->comment,
                $this->authorToken,
                Vote::DOWN
            );
    }

    /**
     * Test remove vote when no exists.
     */
    public function testRemoveNonExistingVote()
    {
        $this
            ->voteDirector
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this
            ->voteDirector
            ->expects($this->never())
            ->method('remove');

        $this
            ->voteManager
            ->removeVote(
                $this->comment,
                $this->authorToken,
                Vote::DOWN
            );
    }
}
