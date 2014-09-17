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

namespace Elcodi\Component\Comment\Event;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Entity\Interfaces\VoteInterface;
use Elcodi\Component\Comment\Event\Abstracts\AbstractCommentEvent;

/**
 * Class CommentOnVotedEvent
 */
class CommentOnVotedEvent extends AbstractCommentEvent
{
    /**
     * @var VoteInterface
     *
     * Vote
     */
    protected $vote;

    /**
     * @var boolean
     *
     * Edited
     */
    protected $edited;

    /**
     * Construct method
     *
     * @param CommentInterface $comment Comment
     * @param VoteInterface    $vote    Vote
     * @param boolean          $edited  Vote is edition of one already added
     */
    public function __construct(
        CommentInterface $comment,
        VoteInterface $vote,
        $edited
    )
    {
        parent::__construct($comment);

        $this->vote = $vote;
    }

    /**
     * Get Vote
     *
     * @return mixed Vote
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Get Edited
     *
     * @return boolean Edited
     */
    public function getEdited()
    {
        return $this->edited;
    }
}
