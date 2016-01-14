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
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Core\Services\ObjectDirector;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;

/**
 * Class CommentManager.
 */
class CommentManager extends AbstractCacheWrapper
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
     * Comment Director
     */
    private $commentDirector;

    /**
     * Construct method.
     *
     * @param CommentEventDispatcher $commentEventDispatcher Comment event dispatcher
     * @param ObjectDirector         $commentDirector        Comment Director
     */
    public function __construct(
        CommentEventDispatcher $commentEventDispatcher,
        ObjectDirector $commentDirector
    ) {
        $this->commentEventDispatcher = $commentEventDispatcher;
        $this->commentDirector = $commentDirector;
    }

    /**
     * Add comment into source.
     *
     * @param string                $source      Source
     * @param string                $context     Context
     * @param string                $content     Content
     * @param string                $authorToken Author token
     * @param string                $authorName  Author name
     * @param string                $authorEmail Author email
     * @param CommentInterface|null $parent      Parent
     *
     * @return CommentInterface Commend added
     */
    public function addComment(
        $source,
        $context,
        $content,
        $authorToken,
        $authorName,
        $authorEmail,
        CommentInterface $parent = null
    ) {
        $comment = $this
            ->commentDirector
            ->create()
            ->setId(round(microtime(true) * 1000))
            ->setParent($parent)
            ->setSource($source)
            ->setAuthorToken($authorToken)
            ->setAuthorName($authorName)
            ->setAuthorEmail($authorEmail)
            ->setContent($content)
            ->setContext($context);

        $this
            ->commentDirector
            ->save($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnAddEvent($comment);

        return $comment;
    }

    /**
     * Edit a comment.
     *
     * @param CommentInterface $comment Comment
     * @param string           $content Content
     *
     * @return CommentInterface Edited comment
     */
    public function editComment(
        CommentInterface $comment,
        $content
    ) {
        $comment->setContent($content);

        $this
            ->commentDirector
            ->save($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnEditEvent($comment);

        return $this;
    }

    /**
     * Remove a comment.
     *
     * @param CommentInterface $comment Comment
     *
     * @return $this Self object
     */
    public function removeComment(CommentInterface $comment)
    {
        $this
            ->commentEventDispatcher
            ->dispatchCommentPreRemoveEvent($comment);

        $this
            ->commentDirector
            ->save($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnRemoveEvent($comment);

        return $this;
    }
}
