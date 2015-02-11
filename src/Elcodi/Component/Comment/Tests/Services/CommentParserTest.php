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
 * @author Elcodi Team <tech@elcodi.com>
 */

namespace Elcodi\Component\Comment\Tests\Services;

use PHPUnit_Framework_TestCase;
use Elcodi\Component\Comment\Entity\Comment;
use Elcodi\Component\Comment\Services\CommentParser;

/**
 * Class CommentParserTest
 */
class CommentParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test parse content
     */
    public function testParse()
    {
        $adapter = $this->getMock('Elcodi\Component\Core\Adapter\Parser\Interfaces\ParserAdapterInterface');

        $adapter
            ->expects($this->any())
            ->method('parse')
            ->will($this->returnValue('<h1>Hi!</h1>'));

        $adapter
            ->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue('adapter'));

        $commentParser = new CommentParser($adapter);
        $comment = new Comment();
        $comment->setContent('# Hi!');
        $commentParser->parse($comment);

        $this->assertEquals('# Hi!', $comment->getContent());
        $this->assertEquals('<h1>Hi!</h1>', $comment->getParsedContent());
        $this->assertEquals('adapter', $comment->getParsingType());
    }
}
