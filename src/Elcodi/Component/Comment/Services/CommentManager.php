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

namespace Elcodi\Component\Comment\Services;

use Doctrine\Common\Persistence\ObjectManager;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\EventDispatcher\CommentEventDispatcher;
use Elcodi\Component\Comment\Factory\CommentFactory;
use Elcodi\Component\Comment\Repository\CommentRepository;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;
use Elcodi\Component\User\Entity\Interfaces\AbstractUserInterface;

/**
 * Class CommentManager
 */
class CommentManager extends AbstractCacheWrapper
{
    /**
     * @var CommentEventDispatcher
     *
     * Comment event dispatcher
     */
    protected $commentEventDispatcher;

    /**
     * @var ObjectManager
     *
     * Comment Object Manager
     */
    protected $commentObjectManager;

    /**
     * @var CommentRepository
     *
     * Comment repository
     */
    protected $commentRepository;

    /**
     * @var CommentFactory
     *
     * Comment factory
     */
    protected $commentFactory;

    /**
     * @var CommentParser
     *
     * Comment parser
     */
    protected $commentParser;

    /**
     * Construct method
     *
     * @param CommentEventDispatcher $commentEventDispatcher Comment event dispatcher
     * @param ObjectManager          $commentObjectManager   Comment object manager
     * @param CommentRepository      $commentRepository      Comment Repository
     * @param CommentFactory         $commentFactory         Comment Factory
     * @param CommentParser          $commentParser          Comment parser
     */
    public function __construct(
        CommentEventDispatcher $commentEventDispatcher,
        ObjectManager $commentObjectManager,
        CommentRepository $commentRepository,
        CommentFactory $commentFactory,
        CommentParser $commentParser
    )
    {
        $this->commentEventDispatcher = $commentEventDispatcher;
        $this->commentObjectManager = $commentObjectManager;
        $this->commentRepository = $commentRepository;
        $this->commentFactory = $commentFactory;
        $this->commentParser = $commentParser;
    }

    /**
     * Add comment into source
     *
     * @param string                $source  Source
     * @param string                $content Content
     * @param AbstractUserInterface $author  Author
     * @param CommentInterface|null $parent  Parent
     *
     * @return CommentInterface Commend added
     */
    public function addComment(
        $source,
        $content,
        AbstractUserInterface $author,
        CommentInterface $parent = null
    )
    {
        $comment = $this
            ->commentFactory
            ->create()
            ->setId(round(microtime(true) * 1000))
            ->setParent($parent)
            ->setSource($source)
            ->setAuthor($author)
            ->setContent($content);

        $comment = $this
            ->commentParser
            ->parse($comment);

        $this
            ->commentObjectManager
            ->persist($comment);

        $this
            ->commentObjectManager
            ->flush($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnAddEvent($comment);

        return $comment;
    }

    /**
     * Edit a comment
     *
     * @param CommentInterface $comment Comment
     * @param string           $content Content
     *
     * @return CommentInterface Edited comment
     */
    public function editComment(
        CommentInterface $comment,
        $content
    )
    {
        $comment->setContent($content);

        $comment = $this
            ->commentParser
            ->parse($comment);

        $this
            ->commentObjectManager
            ->flush($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnEditEvent($comment);

        return $this;
    }

    /**
     * Remove a comment
     *
     * @param CommentInterface $comment Comment
     *
     * @return CommentManager self Object
     */
    public function removeComment(CommentInterface $comment)
    {
        $this
            ->commentEventDispatcher
            ->dispatchCommentPreRemoveEvent($comment);

        $this
            ->commentObjectManager
            ->remove($comment);

        $this
            ->commentObjectManager
            ->flush($comment);

        $this
            ->commentEventDispatcher
            ->dispatchCommentOnRemoveEvent($comment);

        return $this;
    }
}
