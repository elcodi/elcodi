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
use Elcodi\Component\Comment\Entity\VotePackage;
use Elcodi\Component\Comment\Repository\CommentRepository;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;

/**
 * Class CommentCache.
 */
class CommentCache extends AbstractCacheWrapper
{
    /**
     * @var CommentRepository
     *
     * Comment repository
     */
    private $commentRepository;

    /**
     * @var VoteManager
     *
     * Vote manager
     */
    private $voteManager;

    /**
     * @var array|null
     *
     * Comment tree
     */
    private $commentTree;

    /**
     * @var string
     *
     * Key
     */
    private $key;

    /**
     * Construct method.
     *
     * @param CommentRepository $commentRepository Comment Repository
     * @param VoteManager       $voteManager       Vote manager
     * @param string            $key               Key where to store info
     */
    public function __construct(
        CommentRepository $commentRepository,
        VoteManager $voteManager,
        $key
    ) {
        $this->commentRepository = $commentRepository;
        $this->voteManager = $voteManager;
        $this->key = $key;
    }

    /**
     * Get comment tree.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comment tree
     */
    public function getCommentTree($source, $context)
    {
        $key = $this->getSpecificSourceCacheKey(
            $source,
            $context
        );

        return isset($this->commentTree[$key])
            ? $this->commentTree[$key]
            : [];
    }

    /**
     * Load Comment tree from cache.
     *
     * If element is not loaded yet, loads it from Database and store it into
     * cache.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comment tree loaded
     */
    public function load($source, $context)
    {
        $key = $this->getSpecificSourceCacheKey(
            $source,
            $context
        );

        if (isset($this->commentTree[$key]) && is_array($this->commentTree[$key])) {
            return $this->commentTree[$key];
        }

        /**
         * Fetch key from cache.
         */
        $commentTree = $this->loadCommentTreeFromCache($source, $context);

        /**
         * If cache key is empty, build it.
         */
        if (empty($commentTree)) {
            $commentTree = $this->buildCommentTreeAndSaveIntoCache($source, $context);
        }

        $this->commentTree[$key] = $commentTree;

        return $commentTree;
    }

    /**
     * Invalidates cache from source.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return $this Self object
     */
    public function invalidateCache($source, $context)
    {
        $key = $this->getSpecificSourceCacheKey(
            $source,
            $context
        );

        $this
            ->cache
            ->delete($this->getSpecificSourceCacheKey(
                $source,
                $context
            ));

        unset($this->commentTree[$key]);

        return $this;
    }

    /**
     * Invalidates cache and reload all cache from source.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comment tree loaded
     */
    public function reload($source, $context)
    {
        $this->invalidateCache(
            $source,
            $context
        );

        return $this->load(
            $source,
            $context
        );
    }

    /**
     * Create structure for comment.
     *
     * @param CommentInterface $comment            Comment
     * @param VotePackage      $commentVotePackage Vote package
     *
     * @return array
     */
    public function createCommentStructure(
        CommentInterface $comment,
        VotePackage $commentVotePackage = null
    ) {
        $commentStructure = [
            'id' => $comment->getId(),
            'authorName' => $comment->getAuthorName(),
            'authorEmail' => $comment->getAuthorEmail(),
            'content' => $comment->getContent(),
            'context' => $comment->getContext(),
            'createdAt' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $comment->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];

        if ($commentVotePackage instanceof VotePackage) {
            $commentStructure = array_merge(
                $commentStructure,
                [
                    'nbVotes' => $commentVotePackage->getNbVotes(),
                    'nbUpVotes' => $commentVotePackage->getNbUpVotes(),
                    'nbDownVotes' => $commentVotePackage->getNbDownVotes(),
                ]
            );
        }

        return $commentStructure;
    }

    /**
     * Load comment tree from cache.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comment tree
     */
    private function loadCommentTreeFromCache($source, $context)
    {
        return $this
            ->encoder
            ->decode(
                $this
                    ->cache
                    ->fetch($this->getSpecificSourceCacheKey(
                        $source,
                        $context
                    ))
            );
    }

    /**
     * Build comment tree and save it into cache.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comment tree
     */
    private function buildCommentTreeAndSaveIntoCache($source, $context)
    {
        $commentTree = $this->buildCommentTree($source, $context);
        $this->saveCommentTreeIntoCache(
            $commentTree,
            $source,
            $context
        );

        return $commentTree;
    }

    /**
     * Build comments tree from doctrine given their source.
     *
     * cost O(n)
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return array Comments tree given the source
     */
    private function buildCommentTree($source, $context)
    {
        $comments = $this
            ->commentRepository
            ->getAllCommentsSortedByParentAndIdAsc($source, $context);

        $commentTree = [
            0 => null,
            'children' => [],
        ];

        /**
         * @var CommentInterface $comment
         */
        foreach ($comments as $comment) {
            $parentCommentId = 0;
            $commentId = $comment->getId();

            if ($comment->getParent() instanceof CommentInterface) {
                $parentCommentId = $comment->getParent()->getId();
            }

            if ($parentCommentId && !isset($commentTree[$parentCommentId])) {
                $commentTree[$parentCommentId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            if (!isset($commentTree[$commentId])) {
                $commentTree[$commentId] = [
                    'entity' => null,
                    'children' => [],
                ];
            }

            $commentVotePackage = $this
                ->voteManager
                ->getCommentVotes($comment);

            $commentTree[$commentId]['entity'] = $this->createCommentStructure(
                $comment,
                $commentVotePackage
            );

            $commentTree[$parentCommentId]['children'][] = &$commentTree[$commentId];
        }

        return $commentTree[0]['children']
            ?: [];
    }

    /**
     * Save given comment tree into cache.
     *
     * @param array  $commentTree Comment tree
     * @param string $source      Source of comments
     * @param string $context     Context of comment
     *
     * @return $this Self object
     */
    private function saveCommentTreeIntoCache(array $commentTree, $source, $context)
    {
        $this
            ->cache
            ->save(
                $this->getSpecificSourceCacheKey($source, $context),
                $this->encoder->encode($commentTree)
            );

        return $this;
    }

    /**
     * Get cache key given the source.
     *
     * @param string $source  Source of comments
     * @param string $context Context of comment
     *
     * @return string specific source cache key
     */
    private function getSpecificSourceCacheKey($source, $context)
    {
        $source = str_replace('.', '_', $source);
        $context = str_replace('.', '_', $context);

        return $this->key . '.' . $source . '.' . $context;
    }
}
