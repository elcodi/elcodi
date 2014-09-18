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

namespace Elcodi\Bundle\CommentBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;
use Elcodi\Component\Comment\Entity\Vote;
use Elcodi\Component\Comment\Services\VoteManager;

/**
 * Class VoteManagerTest
 */
class VoteManagerTest extends WebTestCase
{
    /**
     * Schema must be loaded in all test cases
     *
     * @return boolean Load schema
     */
    protected function loadSchema()
    {
        return true;
    }

    /**
     * Returns the callable name of the service
     *
     * @return string[] service name
     */
    public function getServiceCallableName()
    {
        return [
            'elcodi.core.comment.service.comment_vote_manager',
            'elcodi.comment_vote_manager',
        ];
    }

    /**
     * Test add vote
     */
    public function testVote()
    {
        /**
         * @var VoteManager $voteManager
         */
        $voteManager = $this->get('elcodi.comment_vote_manager');

        $user = $this
            ->getFactory('customer')
            ->create()
            ->setUsername('customer')
            ->setPassword('customer')
            ->setEmail('customer@customer.com');

        $this->flush($user);

        $comment = $this
            ->getFactory('comment')
            ->create()
            ->setSource('source')
            ->setAuthor($user)
            ->setContent('content')
            ->setParsedContent('content')
            ->setParsingType('none');

        $this->flush($comment);

        /**
         * Customer votes UP
         */
        $voteManager->vote(
            $user,
            $comment,
            Vote::UP
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(0, $votePackage->getNbDownVotes());

        /**
         * Customer votes DOWN the same comment
         */
        $voteManager->vote(
            $user,
            $comment,
            Vote::DOWN
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(0, $votePackage->getNbUpVotes());
        $this->assertEquals(1, $votePackage->getNbDownVotes());

        $user2 = $this
            ->getFactory('customer')
            ->create()
            ->setUsername('customer2')
            ->setPassword('customer2')
            ->setEmail('customer2@customer.com');

        $this->flush($user2);

        /**
         * Customer2 votes UP the comment
         */
        $voteManager->vote(
            $user2,
            $comment,
            Vote::UP
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(2, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(1, $votePackage->getNbDownVotes());

        /**
         * Customer removed his vote
         */
        $voteManager->removeVote(
            $user,
            $comment
        );

        $votePackage = $voteManager->getCommentVotes($comment);
        $this->assertEquals(1, $votePackage->getNbVotes());
        $this->assertEquals(1, $votePackage->getNbUpVotes());
        $this->assertEquals(0, $votePackage->getNbDownVotes());
    }
}
