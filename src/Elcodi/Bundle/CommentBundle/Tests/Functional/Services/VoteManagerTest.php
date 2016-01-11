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

namespace Elcodi\Bundle\CommentBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\Services\VoteManager;

/**
 * Class VoteManagerTest.
 */
class VoteManagerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases.
     *
     * @return bool Load schema
     */
    protected static function loadSchema()
    {
        return true;
    }

    /**
     * Test add vote.
     */
    public function testVote()
    {
        /**
         * @var VoteManager $voteManager
         */
        $voteManager = $this->get('elcodi.manager.comment_vote');

        $comment = $this
            ->getFactory('comment')
            ->create()
            ->setSource('source')
            ->setAuthorToken(1234)
            ->setAuthorName('percebe')
            ->setAuthorEmail('sjka@hjdhj.com')
            ->setContent('content')
            ->setContext('admin');

        $this->flush($comment);

        /**
         * Customer votes UP.
         */
        $voteManager->vote(
            $comment,
            '1234',
            Vote::UP
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(0, $votePackage->getNbDownVotes());

        /**
         * Customer votes DOWN the same comment.
         */
        $voteManager->vote(
            $comment,
            '1234',
            Vote::DOWN
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(0, $votePackage->getNbUpVotes());
        $this->assertEquals(1, $votePackage->getNbDownVotes());

        /**
         * Customer2 votes UP the comment.
         */
        $voteManager->vote(
            $comment,
            '5678',
            Vote::UP
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(2, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(1, $votePackage->getNbDownVotes());

        /**
         * Customer removed his vote.
         */
        $voteManager->removeVote(
            $comment,
            '1234'
        );
        $votePackage = $voteManager->getCommentVotes($comment);

        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(0, $votePackage->getNbDownVotes());
    }
}
