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

namespace Elcodi\Component\Comment\Services;

use Elcodi\Component\Comment\Entity\Interfaces\CommentInterface;
use Elcodi\Component\Comment\Repository\CommentRepository;
use Elcodi\Component\Core\Wrapper\Abstracts\AbstractCacheWrapper;

/**
 * Class CommentCache
 */
class CommentCache extends AbstractCacheWrapper
{
    /**
     * @var CommentRepository
     *
     * Comment repository
     */
    protected $commentRepository;

    /**
     * @var VoteManager
     *
     * Vote manager
     */
    protected $voteManager;

    /**
     * @var array
     *
     * Comment tree
     */
    protected $commentTree;

    /**
     * @var string
     *
     * Key
     */
    protected $key;

    /**
     * Construct method
     *
     * @param CommentRepository $commentRepository Comment Repository
     * @param VoteManager       $voteManager       Vote manager
     * @param string            $key               Key where to store info
     */
    public function __construct(
        CommentRepository $commentRepository,
        VoteManager $voteManager,
        $key
    )
    {
        $this->commentRepository = $commentRepository;
        $this->voteManager = $voteManager;
        $this->key = $key;
    }

    /**
     * Get comment tree
     *
     * @param string $source Source of comments
     *
     * @return array Comment tree
     */
    public function getCommentTree($source)
    {
        return $this->commentTree[$source]
            ?: [];
    }

    /**
     * Load Comment tree from cache.
     *
     * If element is not loaded yet, loads it from Database and store it into
     * cache.
     *
     * @param string $source Source of comments
     *
     * @return array Comment tree loaded
     */
    public function load($source)
    {
        if (is_array($this->commentTree[$source])) {
            return $this->commentTree[$source];
        }

        /**
         * Fetch key from cache
         */
        $commentTree = $this->loadCommentTreeFromCache($source);

        /**
         * If cache key is empty, build it
         */
        if (empty($commentTree)) {

            $commentTree = $this->buildCommentTreeAndSaveIntoCache($source);
        }

        $this->commentTree[$source] = $commentTree;

        return $commentTree;
    }

    /**
     * Invalidates cache from source
     *
     * @param string $source Source of comments
     *
     * @return $this self Object
     */
    public function invalidateCache($source)
    {
        $this
            ->cache
            ->delete($this->getSpecificSourceCacheKey($source));

        $this->commentTree = null;

        return $this;
    }

    /**
     * Invalidates cache and reload all cache from source
     *
     * @param string $source Source of comments
     *
     * @return array Comment tree loaded
     */
    public function reload($source)
    {
        $this->invalidateCache($source);

        return $this->load($source);
    }

    /**
     * Load comment tree from cache
     *
     * @param string $source Source of comments
     *
     * @return array Comment tree
     */
    protected function loadCommentTreeFromCache($source)
    {
        return $this
            ->encoder
            ->decode(
                $this
                    ->cache
                    ->fetch($this->getSpecificSourceCacheKey($source))
            );
    }

    /**
     * Build comment tree and save it into cache
     *
     * @param string $source Source of comments
     *
     * @return array Comment tree
     */
    protected function buildCommentTreeAndSaveIntoCache($source)
    {
        $commentTree = $this->buildCommentTree($source);
        $this->saveCommentTreeIntoCache($commentTree, $source);

        return $commentTree;
    }

    /**
     * Build comments tree from doctrine given their source
     *
     * cost O(n)
     *
     * @param string $source Source of comments
     *
     * @return Array Comments tree given the source
     */
    protected function buildCommentTree($source)
    {
        $comments = $this
            ->commentRepository
            ->getAllCommentsSortedByParentAndIdAsc($source);

        $commentTree = [
            0          => null,
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

                $commentTree[$parentCommentId] = array(
                    'entity'   => null,
                    'children' => array(),
                );
            }

            if (!isset($commentTree[$commentId])) {

                $commentTree[$commentId] = array(
                    'entity'   => null,
                    'children' => array(),
                );
            }

            $commentVotePackage = $this
                ->voteManager
                ->getCommentVotes($comment);

            $author = $comment->getAuthor();
            $commentTree[$commentId]['entity'] = array(
                'id'             => $comment->getId(),
                'authorFullName' => $author->getFullName(),
                'authorUsername' => $author->getUsername(),
                'authorEmail'    => $author->getEmail(),
                'content'        => $comment->getContent(),
                'parsedContent'  => $comment->getParsedContent(),
                'parsedType'     => $comment->getParsingType(),
                'nbVotes'        => $commentVotePackage->getNbVotes(),
                'nbUpVotes'      => $commentVotePackage->getNbUpVotes(),
                'nbDownVotes'    => $commentVotePackage->getNbDownVotes(),
            );

            $commentTree[$parentCommentId]['children'][] = &$commentTree[$commentId];
        }

        return $commentTree[0]['children']
            ?: [];
    }

    /**
     * Save given comment tree into cache
     *
     * @param array  $commentTree Comment tree
     * @param string $source      Source of comments
     *
     * @return $this self Object
     */
    protected function saveCommentTreeIntoCache($commentTree, $source)
    {
        $this
            ->cache
            ->save(
                $this->getSpecificSourceCacheKey($source),
                $this->encoder->encode($commentTree)
            );

        return $this;
    }

    /**
     * Get cache key given the source
     *
     * @param string $source Source of comments
     *
     * @return string specific source cache key
     */
    protected function getSpecificSourceCacheKey($source)
    {
        return $this->key . '-' . $source;
    }
}
