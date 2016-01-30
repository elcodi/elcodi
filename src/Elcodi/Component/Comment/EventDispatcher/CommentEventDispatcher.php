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

namespace Elcodi\Component\Comment\EventDispatcher;

use Elcodi\Component\Comment\ElcodiCommentEvents;
use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;
use Elcodi\Component\Comment\Event\CommentOnAddEvent;
use Elcodi\Component\Comment\Event\CommentOnEditEvent;
use Elcodi\Component\Comment\Event\CommentOnRemoveEvent;
use Elcodi\Component\Comment\Event\CommentOnVotedEvent;
use Elcodi\Component\Comment\Event\CommentPreRemoveEvent;
use Elcodi\Component\Core\EventDispatcher\Abstracts\AbstractEventDispatcher;

/**
 * Class CommentEventDispatcher.
 */
class CommentEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch Comment added event.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function dispatchCommentOnAddEvent(CommentInterface $comment)
    {
        $event = new CommentOnAddEvent(
            $comment
        );

        $this
            ->eventDispatcher
            ->dispatch(ElcodiCommentEvents::COMMENT_ONADD, $event);

        return $this;
    }

    /**
     * Dispatch Comment edited event.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function dispatchCommentOnEditEvent(CommentInterface $comment)
    {
        $event = new CommentOnEditEvent(
            $comment
        );

        $this
            ->eventDispatcher
            ->dispatch(ElcodiCommentEvents::COMMENT_ONEDIT, $event);

        return $this;
    }

    /**
     * Dispatch Comment pre removed event.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function dispatchCommentPreRemoveEvent(CommentInterface $comment)
    {
        $event = new CommentPreRemoveEvent(
            $comment
        );

        $this
            ->eventDispatcher
            ->dispatch(ElcodiCommentEvents::COMMENT_PREREMOVE, $event);

        return $this;
    }

    /**
     * Dispatch Comment removed event.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function dispatchCommentOnRemoveEvent(CommentInterface $comment)
    {
        $event = new CommentOnRemoveEvent(
            $comment
        );

        $this
            ->eventDispatcher
            ->dispatch(ElcodiCommentEvents::COMMENT_ONREMOVE, $event);

        return $this;
    }

    /**
     * Dispatch Comment voted event.
     *
     * @param CommentInterface $comment Comment
     * @param VoteInterface    $vote    Vote
     * @param bool             $edited  Vote is edition of one already added
     *
     * @return $this Self object
     */
    public function dispatchCommentOnVotedEvent(
        CommentInterface $comment,
        VoteInterface $vote,
        $edited
    ) {
        $event = new CommentOnVotedEvent(
            $comment,
            $vote,
            $edited
        );

        $this
            ->eventDispatcher
            ->dispatch(ElcodiCommentEvents::COMMENT_ONVOTED, $event);

        return $this;
    }
}
