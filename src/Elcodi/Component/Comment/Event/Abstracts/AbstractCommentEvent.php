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

namespace Elcodi\Component\Comment\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;

/**
 * Class AbstractCommentEvent.
 */
class AbstractCommentEvent extends Event
{
    /**
     * @var CommentInterface
     *
     * Comment
     */
    private $comment;

    /**
     * Construct method.
     *
     * @param CommentInterface $comment Comment
     */
    public function __construct(CommentInterface $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get Comment.
     *
     * @return CommentInterface Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
