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

namespace Elcodi\Component\Comment\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;
use Elcodi\Component\Comment\Entity\VotePackage;
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Comment\Factory\VoteFactory;
use Elcodi\Component\Comment\Repository\VoteRepository;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Class VoteManager
 */
class VoteManager
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
     * Construct
     *
     * @param CommentEventDispatcher $commentEventDispatcher Comment event dispatcher
     * @param VoteFactory            $voteFactory            Vote Factory
     * @param VoteRepository         $voteRepository         Vote Repository
     * @param ObjectManager          $voteObjectManager      Vote Object Manager
     */
    public function __construct(
        CommentEventDispatcher $commentEventDispatcher,
        VoteFactory $voteFactory,
        VoteRepository $voteRepository,
        ObjectManager $voteObjectManager
    )
    {
        $this->commentEventDispatcher = $commentEventDispatcher;
        $this->voteFactory = $voteFactory;
        $this->voteRepository = $voteRepository;
        $this->voteObjectManager = $voteObjectManager;
    }

    /**
     * Vote action
     *
     * @param AbstractUserInterface $user    User
     * @param CommentInterface      $comment Comment
     * @param boolean               $type    Vote type
     *
     * @return VoteInterface Vote
     */
    public function vote(
        AbstractUserInterface $user,
        CommentInterface $comment,
        $type
    )
    {
        /**
         * @var VoteInterface $vote
         */
        $vote = $this
            ->voteRepository
            ->findOneBy([
                'user'    => $user,
                'comment' => $comment,
            ]);

        $edited = true;

        if (!($vote instanceof VoteInterface)) {

            $vote = $this
                ->voteFactory
                ->create()
                ->setUser($user)
                ->setComment($comment);

            $this
                ->voteObjectManager
                ->persist($vote);

            $edited = false;
        }

        $vote->setType($type);

        $this
            ->voteObjectManager
            ->flush($vote);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnVotedEvent($comment, $vote, $edited);

        return $vote;
    }

    /**
     * Remove Vote action
     *
     * @param AbstractUserInterface $user    User
     * @param CommentInterface      $comment Comment
     *
     * @return $this VoteManager
     */
    public function removeVote(
        AbstractUserInterface $user,
        CommentInterface $comment
    )
    {
        /**
         * @var VoteInterface $vote
         */
        $vote = $this
            ->voteRepository
            ->findOneBy([
                'user'    => $user,
                'comment' => $comment,
            ]);

        if ($vote instanceof VoteInterface) {

            $this
                ->voteObjectManager
                ->remove($vote);

            $this
                ->voteObjectManager
                ->flush($vote);
        }

        return $this;
    }

    /**
     * Get comment votes
     *
     * @param CommentInterface $comment Comment
     *
     * @return VotePackage Vote package
     */
    public function getCommentVotes(CommentInterface $comment)
    {
        /**
         * @var VoteInterface[] $votes
         */
        $votes = $this
            ->voteRepository
            ->findBy([
                'comment' => $comment
            ]);

        return VotePackage::create($votes);
    }
}
