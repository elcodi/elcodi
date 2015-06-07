<?php

/*
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014-2015 Elcodi.com
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
use Elcodi\Component\Core\Adapter\Parser\Interfaces\ParserAdapterInterface;

/**
 * Class CommentParser
 */
class CommentParser
{
    /**
     * @var ParserAdapterInterface
     *
     * Parser adapter
     */
    private $parserAdapter;

    /**
     * Construct
     *
     * @param ParserAdapterInterface $parserAdapter Parser adapter
     */
    public function __construct(ParserAdapterInterface $parserAdapter)
    {
        $this->parserAdapter = $parserAdapter;
    }

    /**
     * Parses comment content
     *
     * @param CommentInterface $comment Comment
     *
     * @return CommentInterface comment parsed
     */
    public function parse(CommentInterface $comment)
    {
        $content = $comment->getContent();
        $parsedContent = $this
            ->parserAdapter
            ->parse($content);

        $parsedType = $this
            ->parserAdapter
            ->getIdentifier();

        $comment
            ->setParsedContent($parsedContent)
            ->setParsingType($parsedType);

        return $comment;
    }
}
