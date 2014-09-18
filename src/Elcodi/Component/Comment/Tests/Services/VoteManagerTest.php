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

use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit_Framework_TestCase;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Comment\Factory\VoteFactory;
use Elcodi\Component\Comment\Repository\VoteRepository;
use Elcodi\Component\Comment\Services\VoteManager;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Class VoteManagerTest
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
     * @var VoteFactory
     *
     * Vote factory
     */
    protected $voteFactory;

    /**
     * @var VoteRepository
     *
     * Vote repository
     */
    protected $voteRepository;

    /**
     * @var ObjectManager
     *
     * Vote Object Manager
     */
    protected $voteObjectManager;

    /**
     * @var AbstractUserInterface
     *
     * User
     */
    protected $user;

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
     * Setup
     */
    public function setUp()
    {
        $this->commentEventDispatcher = $this->getMock('Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher', [], [], '', false);
        $this->voteFactory = $this->getMock('Elcodi\Component\Comment\Factory\VoteFactory', [], [], '', false);
        $this->voteRepository = $this->getMock('Elcodi\Component\Comment\Repository\VoteRepository', [], [], '', false);
        $this->voteObjectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->user = $this->getMock('Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface');
        $this->comment = $this->getMock('Elcodi\Component\Comment\Entity\Interfaces\CommentInterface');

        $this->voteManager = new VoteManager(
            $this->commentEventDispatcher,
            $this->voteFactory,
            $this->voteRepository,
            $this->voteObjectManager
        );
    }

    /**
     * Test vote when no exists
     */
    public function testVote()
    {
        $vote = new Vote;
        $this
            ->voteRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this
            ->voteFactory
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
                $this->user,
                $this->comment,
                Vote::DOWN
            );

        $this->assertSame($this->user, $vote->getUser());
        $this->assertSame($this->comment, $vote->getComment());
        $this->assertSame(Vote::DOWN, $vote->getType());
    }

    /**
     * Test vote when exists
     */
    public function testExistingVote()
    {
        $vote = new Vote();
        $vote
            ->setUser($this->user)
            ->setComment($this->comment)
            ->setType(Vote::UP);

        $this
            ->voteRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($vote));

        $this
            ->voteFactory
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
                $this->user,
                $this->comment,
                Vote::DOWN
            );

        $this->assertSame($this->user, $vote->getUser());
        $this->assertSame($this->comment, $vote->getComment());
        $this->assertSame(Vote::DOWN, $vote->getType());
    }

    /**
     * Test remove vote when exists
     */
    public function testRemoveExistingVote()
    {
        $vote = new Vote();
        $vote
            ->setUser($this->user)
            ->setComment($this->comment)
            ->setType(Vote::UP);

        $this
            ->voteRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue($vote));

        $this
            ->voteObjectManager
            ->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($vote));

        $this
            ->voteManager
            ->removeVote(
                $this->user,
                $this->comment,
                Vote::DOWN
            );
    }

    /**
     * Test remove vote when no exists
     */
    public function testRemoveNonExistingVote()
    {
        $this
            ->voteRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $this
            ->voteObjectManager
            ->expects($this->never())
            ->method('remove');

        $this
            ->voteManager
            ->removeVote(
                $this->user,
                $this->comment,
                Vote::DOWN
            );
    }
}
