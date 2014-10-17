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

namespace Elcodi\Component\Comment\EventListener;

use Elcodi\Component\Comment\Event\Abstracts\AbstractCommentEvent;
use Elcodi\Component\Comment\Services\CommentCache;

/**
 * Class CommentEventListener
 */
class CommentEventListener
{
    /**
     * @var CommentCache
     *
     * Comment cache
     */
    protected $commentCache;

    /**
     * Construct
     *
     * @param CommentCache $commentCache Comment cache
     */
    public function __construct(CommentCache $commentCache)
    {
        $this->commentCache = $commentCache;
    }

    /**
     * on Comment change
     *
     * @param AbstractCommentEvent $event Event
     */
    public function onCommentChange(AbstractCommentEvent $event)
    {
        $source = $event
            ->getComment()
            ->getSource();

        $this
            ->commentCache
            ->invalidateCache($source);
    }
}
