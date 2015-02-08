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

namespace Elcodi\Component\Comment\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Services\CommentCache;
use Elcodi\Component\Comment\Services\CommentManager;

/**
 * Class CommentController
 */
class CommentController
{
    /**
     * @var CommentManager
     *
     * Comment manager
     */
    protected $commentManager;

    /**
     * @var CommentCache
     *
     * Comment Cache
     */
    protected $commentCache;

    /**
     * @var ObjectRepository
     *
     * Comment repository
     */
    protected $commentRepository;

    /**
     * Construct
     *
     * @param CommentManager   $commentManager    Comment manager
     * @param CommentCache     $commentCache      Comment cache
     * @param ObjectRepository $commentRepository Comment Repository
     */
    public function __construct(
        CommentManager $commentManager,
        CommentCache $commentCache,
        ObjectRepository $commentRepository
    )
    {
        $this->commentManager = $commentManager;
        $this->commentCache = $commentCache;
        $this->commentRepository = $commentRepository;
    }

    /**
     * List comments
     *
     * @param string $context Context
     * @param string $source  Source
     *
     * @return array Comments
     */
    public function listComments($context, $source)
    {
        $comments = $this
            ->commentCache
            ->load($source, $context);

        return new Response(json_encode($comments));
    }

    /**
     * Add a comment
     *
     * @param Request $request
     * @param         $authorToken
     * @param         $context
     * @param         $source
     *
     * @return Response
     */
    public function addComment(
        Request $request,
        $authorToken,
        $context,
        $source
    )
    {
        $requestBag = $request->request;
        $content = $requestBag->get('content');
        $authorName = $requestBag->get('author_name');
        $authorEmail = $requestBag->get('author_email');
        $parentId = $requestBag->get('parent');

        $parent = $parentId > 0
            ? $this->commentRepository->find($parentId)
            : null;

        $comment = $this
            ->commentManager
            ->addComment(
                $source,
                $context,
                $content,
                $authorToken,
                $authorName,
                $authorEmail,
                $parent
            );

        $commentStructure = $this
            ->commentCache
            ->createCommentStructure($comment);

        return new Response(json_encode([
            'entity' => $commentStructure,
            'children' => []
        ]));
    }

    /**
     * Edit a comment
     *
     * @param Request $request
     * @param         $commentId
     * @param         $authorToken
     *
     * @return Response
     *
     * @throws EntityNotFoundException
     */
    public function editComment(
        Request $request,
        $commentId,
        $authorToken
    )
    {
        $requestBag = $request->request;
        $content = $requestBag->get('content');
        $comment = $this->findComment(
            $commentId,
            $authorToken
        );

        $this
            ->commentManager
            ->editComment(
                $comment,
                $content
            );

        return new Response();
    }

    /**
     * Delete a comment
     *
     * @param $commentId
     * @param $authorToken
     *
     * @return Response
     * @throws EntityNotFoundException
     */
    public function deleteComments($commentId, $authorToken)
    {
        $comment = $this->findComment(
            $commentId,
            $authorToken
        );

        $this
            ->commentManager
            ->removeComment(
                $comment
            );

        return new Response();
    }

    /**
     * Load comment
     *
     * @param string $commentId   Comment id
     * @param string $authorToken Author token
     *
     * @return CommentInterface Comment
     *
     * @throws EntityNotFoundException Comment not found
     */
    protected function findComment($commentId, $authorToken)
    {
        $comment = $this
            ->commentRepository
            ->findOneBy([
                'id'          => $commentId,
                'authorToken' => $authorToken
            ]);

        if (!($comment instanceof CommentInterface)) {

            throw new EntityNotFoundException('Comment not found');
        }

        return $comment;
    }
}
