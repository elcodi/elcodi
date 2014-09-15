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

namespace Elcodi\Component\Comment\Adapter\Parser;

use Elcodi\Component\Comment\Adapter\Parser\Interfaces\ParserAdapterInterface;

/**
 * Class DummyParserAdapter
 */
class DummyParserAdapter implements ParserAdapterInterface
{
    /**
     * @var string
     *
     * Adapter name
     */
    const ADAPTER_NAME = 'none';

    /**
     * Return the parser identifier
     *
     * @return string Parser identifier
     */
    public function getIdentifier()
    {
        return 'none';
    }

    /**
     * Transform plain text to parsed content
     *
     * @param string $text Text to transform
     *
     * @return string Transformed string
     */
    public function parse($text)
    {
        return $text;
    }
}
