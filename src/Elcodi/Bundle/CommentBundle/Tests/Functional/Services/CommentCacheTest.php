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

/**
 * Class CommentCacheTest.
 */
class CommentCacheTest extends WebTestCase
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
     * Test load.
     */
    public function testLoad()
    {
        $commentCache = $this->get('elcodi.comment_cache');
        $commentManager = $this->get('elcodi.manager.comment');
        $source = 'product-1';
        $comment1 = $commentManager->addComment(
            $source,
            'admin',
            'This is my comment #1',
            '1234',
            'Efervescencio',
            'uhsi@noseque.com',
            null
        );

        $comments = $commentCache->load($source, 'admin');
        $this->assertCount(1, $comments);
        $this->assertEmpty($comments[0]['children']);

        $comments = $commentCache->getCommentTree($source, 'admin');
        $this->assertCount(1, $comments);
        $this->assertEmpty($comments[0]['children']);

        $commentManager->addComment(
            $source,
            'admin',
            'This is my comment #2',
            '1234',
            'Percebe',
            'vestu@quinacosa.com',
            $comment1
        );

        $comments = $commentCache->getCommentTree($source, 'admin');
        $this->assertEmpty($comments);

        $comments = $commentCache->load($source, 'admin');
        $this->assertCount(1, $comments);
        $this->assertCount(1, $comments[0]['children']);
        $this->assertCount(0, $comments[0]['children'][0]['children']);

        $commentManager->addComment(
            $source,
            'admin',
            'This is my comment #3',
            '1234',
            'Efervescencio',
            'uhsi@noseque.com',
            null
        );

        $comments = $commentCache->load($source, 'admin');
        $this->assertCount(2, $comments);

        $comments = $commentCache->load($source, 'noadmin');
        $this->assertCount(0, $comments);
    }
}
