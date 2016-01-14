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

namespace Elcodi\Component\Comment;

/**
 * Class ElcodiCommentEvents.
 */
final class ElcodiCommentEvents
{
    /**
     * This event is dispatched when a comment is added.
     *
     * event.name : comment.onadd
     * event.class : CommentOnAddEvent
     */
    const COMMENT_ONADD = 'comment.onadd';

    /**
     * This event is dispatched when a comment is edited.
     *
     * event.name : comment.onedit
     * event.class : CommentOnEditEvent
     */
    const COMMENT_ONEDIT = 'comment.onedit';

    /**
     * This event is dispatched before a comment is removed.
     *
     * event.name : comment.preremove
     * event.class : CommentPreRemoveEvent
     */
    const COMMENT_PREREMOVE = 'comment.preremove';

    /**
     * This event is dispatched when a comment is removed.
     *
     * event.name : comment.onremove
     * event.class : CommentOnRemoveEvent
     */
    const COMMENT_ONREMOVE = 'comment.onremove';

    /**
     * This event is dispatched when a comment is voted.
     *
     * event.name : comment.onvoted
     * event.class : CommentOnVotedEvent
     */
    const COMMENT_ONVOTED = 'comment.onvoted';
}
