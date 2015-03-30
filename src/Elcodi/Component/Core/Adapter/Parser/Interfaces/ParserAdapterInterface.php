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

namespace Elcodi\Component\Core\Adapter\Parser\Interfaces;

/**
 * Interface ParserAdapterInterface
 */
interface ParserAdapterInterface
{
    /**
     * Return the parser identifier
     *
     * @return string Parser identifier
     */
    public function getIdentifier();

    /**
     * Transform plain text to parsed content
     *
     * @param string $text Text to transform
     *
     * @return string Transformed string
     */
    public function parse($text);
}
