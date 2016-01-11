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

namespace Elcodi\Component\Comment\Services;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;
use Elcodi\Component\Comment\Entity\VotePackage;
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Core\Services\ObjectDirector;

/**
 * Class VoteManager.
 */
class VoteManager
{
    /**
     * @var CommentEventDispatcher
     *
     * Comment event dispatcher
     */
    private $commentEventDispatcher;

    /**
     * @var ObjectDirector
     *
     * Comment vote Object Director
     */
    private $commentVoteObjectDirector;

    /**
     * Construct.
     *
     * @param CommentEventDispatcher $commentEventDispatcher    Comment event dispatcher
     * @param ObjectDirector         $commentVoteObjectDirector Comment vote Object Director
     */
    public function __construct(
        CommentEventDispatcher $commentEventDispatcher,
        ObjectDirector $commentVoteObjectDirector
    ) {
        $this->commentEventDispatcher = $commentEventDispatcher;
        $this->commentVoteObjectDirector = $commentVoteObjectDirector;
    }

    /**
     * Vote action.
     *
     * @param CommentInterface $comment     Comment
     * @param string           $authorToken Author token
     * @param bool             $type        Vote type
     *
     * @return VoteInterface Vote
     */
    public function vote(
        CommentInterface $comment,
        $authorToken,
        $type
    ) {
        /**
         * @var VoteInterface $vote
         */
        $vote = $this
            ->commentVoteObjectDirector
            ->findOneBy([
                'authorToken' => $authorToken,
                'comment' => $comment,
            ]);

        $edited = true;

        if (!($vote instanceof VoteInterface)) {
            $vote = $this
                ->commentVoteObjectDirector
                ->create()
                ->setAuthorToken($authorToken)
                ->setComment($comment);

            $edited = false;
        }

        $vote->setType($type);

        $this
            ->commentVoteObjectDirector
            ->save($vote);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnVotedEvent($comment, $vote, $edited);

        return $vote;
    }

    /**
     * Remove Vote action.
     *
     * @param CommentInterface $comment     Comment
     * @param string           $authorToken Author token
     *
     * @return $this VoteManager
     */
    public function removeVote(
        CommentInterface $comment,
        $authorToken
    ) {
        /**
         * @var VoteInterface $vote
         */
        $vote = $this
            ->commentVoteObjectDirector
            ->findOneBy([
                'authorToken' => $authorToken,
                'comment' => $comment,
            ]);

        if ($vote instanceof VoteInterface) {
            $this
                ->commentVoteObjectDirector
                ->remove($vote);
        }

        return $this;
    }

    /**
     * Get comment votes.
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
            ->commentVoteObjectDirector
            ->findBy([
                'comment' => $comment,
            ]);

        return VotePackage::create($votes);
    }
}
