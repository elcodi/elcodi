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

namespace Elcodi\Bundle\CommentBundle\Tests\Functional\Services;

use Elcodi\Bundle\TestCommonBundle\Functional\WebTestCase;

/**
 * Class CommentCacheTest
 */
class CommentCacheTest extends WebTestCase
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
            'elcodi.core.comment.service.comment_cache',
            'elcodi.comment_cache',
        ];
    }

    /**
     * Test load
     */
    public function testLoad()
    {
        $user = $this
            ->getFactory('customer')
            ->create()
            ->setUsername('customer')
            ->setPassword('customer')
            ->setEmail('customer@customer.com');

        $this->flush($user);

        $commentCache = $this->get('elcodi.comment_cache');
        $commentManager = $this->get('elcodi.comment_manager');
        $source = 'http://page.com/product1';
        $comment1 = $commentManager->addComment(
            $source,
            'This is my comment #1',
            $user,
            null
        );

        $comments = $commentCache->load($source);
        $this->assertCount(1, $comments);
        $this->assertEmpty($comments[0]['children']);

        $comments = $commentCache->getCommentTree($source);
        $this->assertCount(1, $comments);
        $this->assertEmpty($comments[0]['children']);

        $commentManager->addComment(
            $source,
            'This is my comment #2',
            $user,
            $comment1
        );

        $comments = $commentCache->getCommentTree($source);
        $this->assertEmpty($comments);

        $comments = $commentCache->load($source);
        $this->assertCount(1, $comments);
        $this->assertCount(1, $comments[0]['children']);
        $this->assertCount(0, $comments[0]['children'][0]['children']);

        $commentManager->addComment(
            $source,
            'This is my comment #3',
            $user,
            null
        );

        $comments = $commentCache->load($source);
        $this->assertCount(2, $comments);
    }
}
